<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesFactures extends Controller
{
  private $auth_params_entreprise = ['nom', 'email', 'rue', 'code_postal', 'ville', 'prix_unitaire', 'offre', 'num_facture', 'send'];

  public function save_entreprise(RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    $exec = array();
    foreach ($params as $k => $v)
    {
      if (!in_array($k, $this->auth_params_entreprise) && !preg_match('#email-[0-9]+#', $k))
        return ($response->withRedirect('/factures'));
      else if (preg_match('#email-[0-9]+#', $k))
        $exec[] = htmlspecialchars($params[$k]);
    }
    $req = $this->container->pdo->prepare(
      'INSERT INTO entreprise (nom, email, rue, code_postal, ville, prix_unitaire, historique)
      VALUES (:nom, :email, :rue, :code_postal, :ville, :prix_unitaire, :historique)');
    $bool = $req->execute(array(
          ':nom' => htmlspecialchars($params['nom']),
          ':email' => serialize($exec),
          ':rue' => htmlspecialchars($params['rue']),
          ':code_postal' => intval(htmlspecialchars($params['code_postal'])),
          ':ville' => htmlspecialchars($params['ville']),
          ':prix_unitaire' => floatval(htmlspecialchars($params['prix_unitaire'])),
          ':historique' => serialize(array())
        ));
    return ($response->withRedirect('/factures'));
  }

  public function facture_gestion(RequestInterface $request, ResponseInterface $response, $args)
  {
    $num_facture = $this->container->pdo->query("SELECT historique FROM entreprise")->fetchAll();
    $count_facture = 0;
    foreach ($num_facture as $k => $v)
      $count_facture = (unserialize($v['historique'])) ? $count_facture + count(unserialize($v['historique'])) : $count_facture;
    $entreprise_envoie = $this->container->pdo->prepare("SELECT content FROM options INNER JOIN user WHERE user.id = options.id_user AND user.id=:id");
    $entreprise_envoie->execute([':id' => $_SESSION['id']]);
    $entreprise = $this->container->pdo->prepare("SELECT * FROM entreprise WHERE id=:id");
    $entreprise->execute([':id' => htmlspecialchars($args['id'])]);
    $ret = $entreprise->fetchAll()[0];
    $historique = unserialize($ret['historique']);
    $total = array(
      'nbr_lead_envoye' => 0,
      'prix_total_hors_tva' => 0,
      'montant_tva' => 0,
      'prix_total_tva' => 0,
      'offert' => 0,
    );
    foreach ($historique as $k => $v)
    {
      $total['nbr_lead_envoye'] = $total['nbr_lead_envoye'] + $v['nbr_lead_envoye'];
      $total['prix_total_hors_tva'] = $total['prix_total_hors_tva'] + $v['prix_total_hors_tva'];
      $totla['montant_tva'] = $total['montant_tva'] + $v['montant_tva'];
      $total['prix_total_tva'] = $total['prix_total_tva'] + $v['prix_total_tva'];
      $total['offre'] = $total['offre'] + $v['offre'];
    }
    $this->render($response, 'pages/factures_details.twig', [
      'entreprise' => $ret,
      'emails' => unserialize($ret['email']),
      'historique' => $historique,
      'num_facture' => $count_facture,
      'entreprise_envoie' => unserialize($entreprise_envoie->fetchAll()[0]['content']),
      'total' => $total
    ]);
  }

  public function update_entreprise (RequestInterface $request, ResponseInterface $response, $args)
  {
    if (!isset($args['id']))
      return ($response->withRedirect('/factures'));
    $params = $request->getParams();
    $exec = array();
    foreach ($params as $k => $v)
    {
      if (!in_array($k, $this->auth_params_entreprise) && !preg_match('#email-[0-9]+#', $k))
        return ($response->withRedirect('/factures'));
      else if (preg_match('#email-[0-9]+#', $k))
        $exec[] = htmlspecialchars($params[$k]);
    }

    $req = $this->container->pdo->prepare(
      'UPDATE entreprise SET nom=:nom, email=:email, rue=:rue, code_postal=:code_postal, ville=:ville, prix_unitaire=:prix_unitaire
      WHERE id=:id');
    $req->execute(array(
      ':nom' => htmlspecialchars($params['nom']),
      ':email' => serialize($exec),
      ':rue' => htmlspecialchars($params['rue']),
      ':code_postal' => htmlspecialchars($params['code_postal']),
      ':ville' => htmlspecialchars($params['ville']),
      ':prix_unitaire' => htmlspecialchars($params['prix_unitaire']) | 0,
      ':id' => $args['id']
    ));
    return ($response->withRedirect('/factures/' . $args['id']));
  }

  public function send_facture(RequestInterface $request, ResponseInterface $response, $args)
  {
    $params = $request->getParams();
    $new_historique = [
       date('d-m-Y H:i:s') => [
        "prix_unitaire" => $params['prix_unitaire'],
        "nbr_lead_envoye" => $params['nbr_lead_envoye'],
        "prix_total_hors_tva" => $params['prix_total_hors_taxe'],
        "montant_tva" => $params['montant_tva'],
        "prix_total_tva" => $params['prix_total_tva'],
        "offre" => $params['offre'],
        "payer" => 0
      ]
    ];
    $req = $this->container->pdo->prepare('SELECT email, historique FROM entreprise WHERE id=:id');
    $req->execute([':id' => $args['id']]);
    $req = $req->fetchAll()[0];
    $historique = unserialize($req['historique']);
    $email = unserialize($req['email']);
    if ($historique)
      $new_historique = array_merge($new_historique, $historique);
    $req = $this->container->pdo->prepare('UPDATE entreprise SET historique=:historique WHERE id=:id');
    $bool = $req->execute([':historique' => serialize($new_historique), ':id' => $args['id']]);

    $match = array();
    $request = "UPDATE info_client SET disponible='0' WHERE ";
    $i = 0;
    foreach ($params as $k => $v)
    {
      if (preg_match('#id_[0-9]+#', $k))
      {
        $match[':id_user' . $i] = $v;
        $request = $request . "id_client=:id_user".$i ." OR ";
        $i++;
      }
    }
    $request = substr($request, 0, strlen($request) - 4);
    $req = $this->container->pdo->prepare($request);
    $bool = $req->execute($match);

    $message = new \Swift_Message("Facture de leads du " . date('d-m-Y'));
    $message->setFrom(['contact@nylconseil.com' => 'Nyl Conseil']);
    $message->setTo($email[0]);
    for ($i = 1; $i < count($email); $i++)
      $message->addTo($email[$i]);
    $message->setReplyTo(['contact@nylconseil.com' => 'Nyl Conseil']);
    $message->attach(\Swift_Attachment::fromPath($_FILES['list_leads']['tmp_name'])->setFilename(date('d-m-Y') . '-leads.zip'));
    $facture = new \Swift_Attachment(base64_decode($params['facture']), date('d-m-Y') . '-facture.pdf', 'application/pdf');
    $message->attach($facture);
    $body = "Bonjour, \n Veuillez trouver ci-joint votre commande de lead du " . date('d-m-Y') . ".\n Cordialement.";
    $message->setBody($body);
    $this->container->mail->send($message);
    return $response->withRedirect('/factures/' . $args['id']);
  }

  public function save_paiement(RequestInterface $request, ResponseInterface $response, $args)
  {
    $req = $this->container->pdo->prepare("SELECT historique FROM entreprise WHERE id=:id");
    $req->execute([':id' => $args['id']]);
    $tab = unserialize($req->fetchAll()[0]['historique']);
    foreach ($json as $k => $v)
    {
      if ($k == $args['id_historique'])
      {
        $tab[$k]['payer'] = $request->getParams()['is_check'];
        break;
      }
    }
    $req = $this->container->pdo->prepare('UPDATE entreprise SET historique=:historique WHERE id=:id');
    $bool = $req->execute([':historique' => serialize($tab), ':id' => $args['id']]);
    return ($bool);
  }

  private function get_data_entreprise()
  {
    $data = $this->container->pdo->query('SELECT id, nom, historique FROM entreprise')->fetchAll();
    foreach ($data as $k => $v)
    {
      $historique = json_decode($v['historique'], true);
      $data = array();
      $keys = array_keys($historique);
      $actual_month = date('m');
      $ret[$v['nom']] = array('id' => $v['id'], 'month' => 0, 'total' => 0);
      foreach ($keys as $val)
      {
        $h_date = explode('-', $val)[1];
        if ($h_date == $actual_month)
            $ret[$v['nom']]['month'] += 1;
        $ret[$v['nom']]['total'] += 1;
      }
    }
    return ($ret);
  }

  public function delete_historique(RequestInterface $request, ResponseInterface $response, $args)
  {
    $params = $request->getParams();
    $id_historique = (isset($params['id_historique'])) ? htmlspecialchars($params['id_historique']) : null;
    $id_entreprise = (isset($args['id'])) ? htmlspecialchars($args['id']) : null;

    var_dump($id_historique);
    var_dump($id_entreprise);
    if ($id_historique && $id_entreprise)
    {
      $req = $this->container->pdo->prepare('SELECT historique FROM entreprise WHERE id=:id');
      $req->execute([':id' => $id_entreprise]);
      $ret = unserialize($req->fetchAll()[0]['historique']);
      if ($ret)
      {
        foreach ($ret as $k => $v)
          if ($k == $id_historique)
            unset($ret[$k]);
        $req = $this->container->pdo->prepare('UPDATE entreprise SET historique=:historique WHERE id=:id');
        $req->execute([':historique' => serialize($ret), ':id' => $id_entreprise]);
      }
    }
  }

  public function list_entreprise(RequestInterface $request, ResponseInterface $response)
  {
    $this->render($response, 'pages/factures.twig', [
      'entreprises' => $this->get_data_entreprise()
    ]);
  }
}

?>
