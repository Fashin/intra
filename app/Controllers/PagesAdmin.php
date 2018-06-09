<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesAdmin extends Controller
{
  private $options = array(
    'super_admin' => 'permission_super_admin',
    'admin' => 'permission_super_admin',
    'telemarketing' => 'permission_telemarketing'
  );

  private function permission_telemarketing()
  {
    $tab = array(
      'current_leads' => NULL
    );
  }

  private function permission_super_admin()
  {
    $tab = array(
      'nom_entreprise'=> NULL,
      'adresse_entreprise'=> NULL,
      'code_postal_entreprise'=> NULL,
      'ville_entreprise'=> NULL,
      'numero_siret'=> NULL
    );
    return ($tab);
  }

  public function modify_user (RequestInterface $request, ResponseInterface $response, $args)
  {
    $params = $request->getParams();
    var_dump($params);
    $req = $this->container->pdo->prepare('UPDATE user SET pseudo=:pseudo, type=:type, email=:email WHERE id=:id');
    $req->execute([
      ':pseudo' => htmlspecialchars($params['pseudo']),
      ':type' => htmlspecialchars($params['type']),
      ':email' => htmlspecialchars($params['email']),
      ':id' => htmlspecialchars($args['id'])
    ]);
    return ($this->redirect_api($response, ($this->__getdev()) ? '127.0.0.1:8080' : 'intra.objectifsolaire.com'));
  }

  public function reset_password_user (RequestInterface $request, ResponseInterface $response, $args)
  {
    $req = $this->container->pdo->prepare('UPDATE user SET password=:password WHERE id=:id');
    $req->execute([
      ':password' => hash('whirlpool', 'azerty'),
      ':id' => htmlspecialchars($args['id'])
    ]);
    return ($this->redirect_api($response, ($this->__getdev()) ? '127.0.0.1:8080' : 'intra.objectifsolaire.com'));
  }

  public function delete_user (RequestInterface $request, ResponseInterface $response, $args)
  {
    $params = $request->getParams();
    $req = $this->container->pdo->prepare("SELECT pseudo FROM user WHERE id=:id");
    $req->execute([':id' => htmlspecialchars($args['id'])]);
    $name = $req->fetchAll()[0]['pseudo'];
    $req = $this->container->pdo->prepare('DELETE FROM user WHERE id=:id');
    $req->execute([
      ':id' => htmlspecialchars($args['id'])
    ]);
    $req = $this->container->pdo->prepare("SELECT content FROM scoreboard WHERE date=:now");
    $req->execute([':now' => date('Y-m-d')]);
    $scoreboard = unserialize($req->fetchAll()[0]['content']);
    foreach ($scoreboard as $k => $v)
      if ($k == $name)
        unset($scoreboard[$k]);
    $req = $this->container->pdo->prepare("UPDATE scoreboard SET content=:content WHERE date=:now");
    $req->execute([
      ':content' => serialize($scoreboard),
      ':now' => date('Y-m-d')
    ]);
    return ($this->redirect_api($response, ($this->__getdev()) ? '127.0.0.1:8080' : 'intra.objectifsolaire.com'));
  }

  public function new_user (RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    $req = $this->container->pdo->prepare("INSERT INTO user (pseudo, password, type, email) VALUES (:pseudo, :password, :type, :email)");
    $req->execute([
      ':pseudo' => htmlspecialchars($params['pseudo']),
      ':password' => hash('whirlpool', 'azerty'),
      ':email' => htmlspecialchars($params['email']),
      ':type' => htmlspecialchars($params['type'])
    ]);
    $id_user = $this->container->pdo->lastInsertId();
    $func = $this->options[$params['type']];
    $content = $this->$func();
    $req = $this->container->pdo->prepare("INSERT INTO options (content, id_user) VALUES (:content, :id_user)");
    $req->execute([':content' => serialize($content), ':id_user' => intval($id_user)]);

    if ($params['type'] == "telemarketing")
    {
      $req = $this->container->pdo->prepare("SELECT content FROM scoreboard WHERE date=:now");
      $req->execute([':now' => date('Y-m-d')]);
      $scoreboard = unserialize($req->fetchAll()[0]['content']);
      $scoreboard[htmlspecialchars($params['pseudo'])] = ['nbr_signature' => 0, 'nbr_rdv' => 0];
      $req = $this->container->pdo->prepare("UPDATE scoreboard SET content=:content WHERE date=:now");
      $req->execute([
        ':content' => serialize($scoreboard),
        ':now' => date('Y-m-d')
      ]);
    }

    $message = new \Swift_Message("Bienvenue a Objectif Solaire");
    $message->setFrom(['admin@objectifsolaire.com' => 'Objectif Solaire']);
    $message->setTo($params['email']);

    $body = "Bonjour, \n";
    $body .= "Bienvenue chez Objectif solaire ! \n";
    $body .= "Tu peux des a présent te connecter sur l'intra en cliquant sur le lien suivant : http://intra.objectifsolaire.com \n";
    $body .= "Ton login est : " . $params['pseudo'] . " \n";
    $body .= "Ton mot de passe est : azerty (n'oublie pas de le modifier des que possible !) \n";
    $body .= "Cordialement.";
    $message->setBody($body);
    $this->container->mail->send($message);

    return ($response->withRedirect('/admin'));
  }

  public function new_site (RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    if (isset($params['site_url']))
    {
      $req = $this->container->pdo->prepare('INSERT INTO site (name, link) VALUES (:name, :link)');
      $req->execute([
        ':name' => htmlspecialchars($params['site_url']),
        ':link' => htmlspecialchars($params['site_link'])
      ]);
    }
    return ($response->withRedirect('/admin'));
  }

  public function update_site (RequestInterface $request, ResponseInterface $response, $args)
  {
    $params = $request->getParams();
    if (isset($args['id']) && isset($params['site_name']))
    {
      $req = $this->container->pdo->prepare('UPDATE site SET name=:name, link=:link WHERE id=:id');
      $req->execute([
        ':name' => htmlspecialchars($params['site_name']),
        ':link' => htmlspecialchars($params['site_url']),
        ':id' => htmlspecialchars($args['id'])
      ]);
    }
    return ($response->withRedirect('/admin'));
  }

  public function delete_site (RequestInterface $request, ResponseInterface $response, $args)
  {
    if (isset($args['id']))
    {
      $req = $this->container->pdo->prepare('DELETE FROM site WHERE id=:id');
      $req->execute([':id' => $args['id']]);
    }
    return ($response->withRedirect('/admin'));
  }

  public function dashboard (RequestInterface $request, ResponseInterface $response)
  {
    $this->render($response, 'pages/admin.twig', [
      'users' => $this->container->pdo->query('SELECT * FROM user')->fetchAll(),
      'sites' => $this->container->pdo->query('SELECT * FROM site')->fetchAll()
    ]);
    return ($response);
  }
}
?>
