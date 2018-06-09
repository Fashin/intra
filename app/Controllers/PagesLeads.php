<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesLeads extends Controller
{
  private $auth_params = [
    'situation', 'projet', 'bien', 'revenue', 'profession', 'nom', 'prenom', 'email', 'telephone', 'code_postal', 'site'
  ];

  private $filter_function = [
    'situation' => [],
    'projet' => [],
    'bien' => [],
    'revenue' => [],
    'profession' => []
  ];

  private $key_value = [
    "Situation" => "situation",
    "Combles" => "projet",
    "cp" => "code_postal",
    "date" => "created_at",
    "Revenus" => "revenue",
    "nom" => "profession",
    "prenom" => "nom",
    "tel" => "telephone",
    "Personnes" => "bien"
  ];

  private function reform_str($str, $key)
  {
      $url = $str;
      $url = preg_replace('#Ç#', 'C', $url);
      $url = preg_replace('#ç#', 'c', $url);
      $url = preg_replace('#è|é|ê|ë#', 'e', $url);
      $url = preg_replace('#È|É|Ê|Ë#', 'E', $url);
      $url = preg_replace('#à|á|â|ã|ä|å#', 'a', $url);
      $url = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $url);
      $url = preg_replace('#ì|í|î|ï#', 'i', $url);
      $url = preg_replace('#Ì|Í|Î|Ï#', 'I', $url);
      $url = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $url);
      $url = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $url);
      $url = preg_replace('#ù|ú|û|ü#', 'u', $url);
      $url = preg_replace('#Ù|Ú|Û|Ü#', 'U', $url);
      $url = preg_replace('#ý|ÿ#', 'y', $url);
      $url = preg_replace('#Ý#', 'Y', $url);
      $url = preg_replace('# #', '_', $url);

      if ($key == "Revenus")
        $url = ($url == "superieur_a_2000?") ? "+2000" : "-2000";
      if ($key == "date")
      {
        $date = explode('/', $url);
        $mois = (intval($date[0]) < 10) ? "0" . $date[0] : $date[0];
        $jour = (intval($date[1]) < 10) ? "0" . $date[1] : $date[1];
        return ("20" . $date[2] . '-' . $mois . '-' . $jour);
      }
      if ($key == "tel")
        return (htmlspecialchars($str));
      return (strtolower($url));
  }

  public function query_lead(RequestInterface $request, ResponseInterface $response, $args)
  {
    $field = 'client.id, nom, prenom, email, code_postal, telephone, situation, projet, bien, revenue, profession, disponible, client.created_at';

    if (isset($args['query']))
    {
      if ($args['query'] == "_")
      {
        if ($args['site_name'] == "all")
        {
          $req = $this->container->pdo->prepare("SELECT " . $field . " FROM client INNER JOIN info_client ON client.id=info_client.id_client");
          $req->execute();
        }
        else
        {
          $req = $this->container->pdo->prepare("SELECT " . $field . " FROM client INNER JOIN info_client ON client.id=info_client.id_client WHERE site=:site");
          $req->execute([':site' => htmlspecialchars($args['site_name'])]);
        }
        print_r(json_encode($req->fetchAll()));
      }
      else
      {
        $condition = explode('&', $args['query']);
        $ret = ""; $cp = ""; $match; $limit = "";
        foreach ($condition as $k => $v)
        {
          $tmp = explode('=', $v);
          foreach ($this->filter_function as $key => $value)
            if (preg_match("/($key)[0-9]+/", $tmp[0]))
              $this->filter_function[$key][] = $tmp[1];
          if (strstr($tmp[0], 'code_postaux'))
            $cp = $cp . 'client.code_postal LIKE "' . $tmp[1] . '%" OR ';
          else if ($tmp[0] == "date")
          {
            $ret = $ret . ' AND client.created_at=:date';
            $exec[':' . $tmp[0]] = $tmp[1];
          }
          else if ($tmp[0] == "date_start")
          {
            $ret = $ret . ' AND client.created_at between :date_start AND ';
            $tmp[1] = explode('-', $tmp[1]);
            $tmp[1] = $tmp[1][0] . "-" . $tmp[1][1] . "-" . $tmp[1][2];
            $exec[':' . $tmp[0]] = $tmp[1];
          }
          else if ($tmp[0] == "date_end")
          {
            $ret = $ret . ':date_end';
            $tmp[1] = explode('-', $tmp[1]);
            $tmp[1] = $tmp[1][0] . "-" . $tmp[1][1] . "-" . $tmp[1][2];
            $exec[':' . $tmp[0]] = $tmp[1];
          }
          else if ($tmp[0] == "disponible")
          {
            $ret = $ret . ' AND (info_client.disponible=:disponible) ';
            $exec[':' . $tmp[0]] = $tmp[1];
          }
          else if ($tmp[0] == "limit")
            $limit = "LIMIT $tmp[1]";
        }
        foreach ($this->filter_function as $key => $value)
        {
          if (!empty($value))
          {
            $ret = $ret . " AND (";
            foreach ($value as $k => $v)
            {
              $ret = $ret . $key . "=:" . $key . $k . " OR ";
              $exec[':' . $key . $k] = $v;
            }
            $ret = substr($ret, 0, strlen($ret) - 4) . ")";
          }
        }
        if (!empty($cp))
        {
          $cp = '(' . substr($cp, 0, strlen($cp) - 4) . ')';
          $ret =  $ret . " AND " . $cp;
        }
        if (!empty($limit))
            $ret = (!empty($ret)) ? $ret . " " . $limit : $limit;
        if ($args['site_name'] == "all")
          $ret = $this->container->pdo->prepare("SELECT " . $field . " FROM client INNER JOIN info_client ON client.id=info_client.id_client " . $ret);
        else
        {
          $exec[':site'] = $args['site_name'];
          $ret = $this->container->pdo->prepare("SELECT " . $field . " FROM client INNER JOIN info_client ON client.id=info_client.id_client WHERE site=:site " . $ret);
        }
        $ret->execute($exec);
        print_r(json_encode($ret->fetchAll()));
        $ret->closeCursor();
      }
      return ($this->redirect_api($response, ($this->__getdev()) ? '127.0.0.1:8080' : 'intra.objectifsolaire.com'));
    }
    else
      return (NULL);
  }

  public function update_disponibilite(RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();

    if (isset($params['id']) && isset($params['value']))
    {
      $req = $this->container->pdo->prepare("UPDATE info_client SET disponible=:disponible WHERE id=:id");
      $req->execute([
        ':disponible' => intval(htmlspecialchars($params['value'])),
        ':id' => intval(htmlspecialchars($params['id']))
      ]);
    }
  }

  public function update_mult_dispo(RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();

    if (isset($params['id_lead']))
    {
      $lead = explode(';', htmlspecialchars($params['id_lead']));
      $exec = [];
      $req = "UPDATE info_client SET disponible=0 WHERE";
      foreach ($lead as $k => $v)
      {
        $req = $req . " id_client = :id_". $k . " OR";
        $exec[':id_' . $k] = intval($v);
      }
      $req = substr($req, 0, strlen($req) - 3);
      $request = $this->container->pdo->prepare($req);
      $bool = $request->execute($exec);
      $bool = true;
      print_r($bool);
    }
    return ($response);
  }

  public function save_lead (RequestInterface $request, ResponseInterface $response)
  {
    $match = array();
    if (!(preg_match('#http:\/\/(.*)#', $_SERVER['HTTP_ORIGIN'], $match)))
      return (NULL);
    $req = $this->container->pdo->prepare('SELECT name FROM site WHERE name=:name');
    $req->execute([':name' => $match[1]]);
    $name = $req->fetchAll()[0][0];
    if (empty($name))
      return (NULL);
    $params = $request->getParams();
    foreach ($params as $k => $v)
      if (!in_array($k, $this->auth_params) && $k != "chauffage")
        return (NULL);
    $req = $this->container->pdo->prepare(
      'INSERT INTO client (nom, prenom, email, code_postal, telephone, site, created_at)
      VALUES (:nom, :prenom, :email, :code_postal, :telephone, :site, :created_at)');
    $bool = $req->execute(array(
      ':nom' => htmlspecialchars($params['nom']),
      ':prenom' => htmlspecialchars($params['prenom']),
      ':email' => htmlspecialchars($params['email']),
      ':code_postal' => intval(htmlspecialchars($params['code_postal'])),
      ':telephone' => htmlspecialchars($params['telephone']),
      ':site' => htmlspecialchars($params['site']),
      ':created_at' => date('Y-m-d')
    ));
    if (!$bool)
      return (NULL);
    $id_client = $this->container->pdo->lastInsertId();
    $req = $this->container->pdo->prepare(
      'INSERT INTO info_client (situation, projet, bien, revenue, profession, id_client)
      VALUES (:situation, :projet, :bien, :revenue, :profession, :id_client)'
    );
    $bool = $req->execute(array(
      ':situation' => htmlspecialchars($params['situation']),
      ':projet' => htmlspecialchars($params['projet']),
      ':bien' => htmlspecialchars($params['bien']),
      ':revenue' => htmlspecialchars($params['revenue']),
      ':profession' => htmlspecialchars($params['profession']),
      ':id_client' => $id_client,
    ));
    if (!$bool)
      return (NULL);
    print_r('success');
    return ($this->redirect_api($response, $name));
  }

  public function save_leads (RequestInterface $request, ResponseInterface $response)
  {
    $leads = $request->getParams()['leads'];
    $exec_client = [];
    $exec_info_client = [];

    foreach ($leads as $k => $v)
    {
      foreach ($v as $key => $value)
      {
        $tmp = $this->reform_str($value, $key);
        unset($leads[$k][$key]);
        $clef = $this->key_value[$key];
        if ($clef == "nom" || $clef == "telephone" || $clef == "code_postal" || $clef == "created_at")
          $exec_client[":". $clef] = $tmp;
        else
          $exec_info_client[":". $clef] = $tmp;
      }
      $exec_client[":site"] = "jordan";
      $exec_client[":prenom"] = "undefined";
      $exec_client[":email"] = "undefined";
      $exec_info_client[":disponible"] = 1;

      // $req = $this->container->pdo->prepare("INSERT INTO client (nom, prenom, email, code_postal, telephone, created_at, site) VALUES (:nom,:prenom,:email,:code_postal,:telephone,:created_at,:site)");
      // $bool = $req->execute($exec_client);
      $bool = true;
      print_r($bool);
      if ($bool)
      {
        // $exec_info_client[":id_client"] = $this->container->pdo->lastInsertId();
        // $req = $this->container->pdo->prepare("INSERT INTO info_client (situation, projet, bien, revenue, profession, id_client, disponible) VALUES (:situation, :projet, :bien, :revenue, :profession, :id_client, :disponible)");
        // $bool = $req->execute($exec_info_client);
        print_r($bool);
      }
    }
    return ($response);
  }

  private function get_one_lead($lead_name)
  {
    if ($lead_name == "all")
    {
      $req = $this->container->pdo->prepare("SELECT * FROM client INNER JOIN info_client ON client.id=info_client.id_client WHERE client.created_at=:today");
      $req->execute([':today' => date('Y-m-d', strtotime('-1 day'))]);
    }
    else
    {
      $req = $this->container->pdo->prepare(
        "SELECT * FROM client INNER JOIN info_client ON client.id=info_client.id_client
        WHERE site=:site AND client.created_at=:today");
        //
      $req->execute(['site' => $lead_name, ':today' => date('Y-m-d', strtotime('-1 day'))]);
      //
    }
    return ($req->fetchAll());
  }

  private function get_postal_code($lead_name)
  {
    if ($lead_name == "all")
    {
      $req = $this->container->pdo->prepare("SELECT code_postal FROM client");
      $req->execute();
    }
    else
    {
      $req = $this->container->pdo->prepare("SELECT code_postal FROM client WHERE site=:site");
      $req->execute([':site' => htmlspecialchars($lead_name)]);
    }
    $res = $req->fetchAll();
    $ret = array();
    foreach ($res as $k => $v)
      $ret[] = intval($v[0][0]) . intval($v[0][1]);
    $ret = array_unique($ret);
    sort($ret, SORT_NUMERIC);
    return ($ret);
  }

  public function delete_lead(RequestInterface $request, ResponseInterface $response, $args)
  {
    $req = $this->container->pdo->prepare(
      "SELECT * FROM client INNER JOIN info_client ON client.id=info_client.id_client
      WHERE client.id=:id");
    $req->execute([
      ':id' => htmlspecialchars($args['id'])
    ]);
    $ret = $req->fetchAll()[0];
    $req = $this->container->pdo->prepare(
      "INSERT INTO archives_clients
      (nom, prenom, email, code_postal, telephone, site, situation, projet, bien, revenue, profession)
      VALUES (:nom, :prenom, :email, :code_postal, :telephone, :site, :situation, :projet, :bien, :revenue, :profession)");
    $req->execute(array(
      ':nom'=> $ret['nom'],
      ':prenom'=> $ret['prenom'],
      ':email'=> $ret['email'],
      ':code_postal'=> $ret['code_postal'],
      ':telephone'=> $ret['telephone'],
      ':site'=> $ret['site'],
      ':situation'=> $ret['situation'],
      ':projet'=> $ret['projet'],
      ':bien'=> $ret['bien'],
      ':revenue'=> $ret['revenue'],
      ':profession'=> $ret['profession']
    ));
    $req = $this->container->pdo->prepare("DELETE FROM client WHERE id=:id");
    $req->execute([':id' => $args['id']]);
    $req = $this->container->pdo->prepare("DELETE FROM info_client WHERE id_client=:id");
    $req->execute([':id' => $args['id']]);
    return ($response);
  }

  public function all_leads(RequestInterface $request, ResponseInterface $response, $args)
  {
    $this->render($response, 'pages/leads.twig', [
      'leads' => $this->get_one_lead(htmlspecialchars($args['site_name'])),
      'cps' => $this->get_postal_code(htmlspecialchars($args['site_name'])),
      'site_name' => $args['site_name'],
      'telepros' => $this->container->pdo->query('SELECT id, pseudo FROM user WHERE type="telemarketing"')->fetchAll()
    ]);
    return ($response);
  }
}

?>
