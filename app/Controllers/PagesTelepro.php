<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesTelepro extends Controller
{

  private $correspondance_region = [
    'HAUT-DE-FRANCE' => ["62", "59", "60", "80", "02"],
    'GRAND-EST' => ["08", "51", "55", "10", "52", "54", "57", "88", "67", "68"],
    'BOURGOGNE-FRANCHE-COMTE' => ["89", "58", "21", "71", "39", "25", "70", "90"],
    'AUVERGNE-RHONE-ALPES' => ["03", "63", "15", "42", "43", "69", "07", "26", "38", "01", "73", "74"],
    'PROVENCE-ALPES-COTE-D-AZUR' => ["05", "04", "84", "13", "83", "06"],
    'OCCITANIE' => ["30", "48", "12", "34", "81", "46", "82", "32", "31", "11", "66", "09", "65"],
    'NOUVELLE-AQUITAINE' => ["79", "86", "17", "16", "87", "23", "19", "24", "33", "47", "40", "64"],
    'CENTRE-VAL-DE-LOIRE' => ["41", "18", "45", "28", "36", "37"],
    'PAYS-DE-LA-LOIRE' => ["72", "49", "53", "44", "85"],
    'BRETAGNE' => ["35", "22", "56", "29"],
    'NORMANDIE' => ["50", "14", "61", "27", "76"],
    'ILE-DE-FRANCE' => ["95", "91", "77", "78", "75", "92", "93", "94"]
  ];

  private function get_region($cp)
  {
    foreach ($this->correspondance_region as $k => $v)
      if (in_array($cp, $v))
        return ($k);
    return (NULL);
  }

  public function new_lead(RequestInterface $request, ResponseInterface $response, $args)
  {
    $params = $request->getParams();
    if (isset($args['id']) && isset($params['id_lead']))
    {
      $req = $this->container->pdo->prepare('SELECT content FROM options WHERE id_user=:id');
      $req->execute([':id' => htmlspecialchars($args['id'])]);
      $content = unserialize($req->fetchAll()[0]['content']);
      $id_leads = explode(';', htmlspecialchars($params['id_lead']));
      if (!$content)
        $content = array();
      for ($i = 0; $i < count($id_leads); $i++)
        $content['current_leads'][intval($id_leads[$i])] = array(
          'send_at' => date('Y-m-d H:i:s'),
        );
      var_dump($content);
      $req = $this->container->pdo->prepare("UPDATE options SET content=:content WHERE id_user=:id_user");
      $bool = $req->execute([
        ':content' => serialize($content),
        ':id_user' => $args['id']
      ]);
      print_r($bool);
    }
    else
      print_r("false");
    return ($response);
  }

  private function get_current_lead($id)
  {
    $id = ($id == undefined) ? $_SESSION['id'] : $id;
    $req = $this->container->pdo->prepare("SELECT content FROM options WHERE id_user=:id");
    $req->execute([':id' => $id]);
    $options = unserialize($req->fetchAll()[0]['content']);
    if (count($options['current_leads']) == 0)
      return (NULL);
    $ret = array();
    $req = "SELECT id, nom, prenom, telephone FROM client WHERE ";
    foreach($options['current_leads'] as $k => $v)
    {
      $req .= "id=:id_$k OR ";
      $exec[':id_' . $k] = $k;
      $send[] = explode(' ', $v['send_at'])[0];
    }
    $req = substr($req, 0, -4);
    $req_client = $this->container->pdo->prepare($req);
    $req_client->execute($exec);
    $data = $req_client->fetchAll();
    foreach ($send as $k => $v)
    {
      if ($data[$k])
        $data[$v][] = $data[$k];
      unset($data[$k]);
    }
    krsort($data);
    foreach ($data as $k => $v)
      array_multisort(array_column($data[$k], 'nom'), SORT_STRING, $data[$k]);
    return ($data);
  }

  private function get_day_from_week($week, $year, $needed_day)
  {
    $days = ["lundi", "mardi", "mercredi", "jeudi"];
    $firstDayInYear = date("N", mktime(0, 0, 0, 1, 1, $year));
    $shift = ($firstDayInYear < 5) ? (-($firstDayInYear - 1) * 86400) : ((8 - $firstDayInYear) * 86400);
    $weekInSeconds = ($week > 1) ? (($week - 1) * 604800) : 0;
    $timestamp = mktime(0, 0, 0, 1, 1, $year) + $weekInSeconds + $shift;
    return (date('Y-m-d', strtotime(array_search($needed_day, $days) . "days", $timestamp)));
  }

  private function add_rdv($id_telepro)
  {
    $req = $this->container->pdo->prepare("SELECT content FROM scoreboard WHERE date=:now");
    $req->execute([':now' => date('Y-m-d')]);
    $scoreboard = unserialize($req->fetchAll()[0]['content']);
    $req = $this->container->pdo->prepare("SELECT pseudo FROM user WHERE id=:id");
    $req->execute([':id' => $id_telepro]);
    $pseudo = $req->fetchAll()[0]['pseudo'];
    foreach ($scoreboard as $k => $v)
      if ($k == $pseudo)
        $scoreboard[$k]['nbr_rdv'] = intval($scoreboard[$k]['nbr_rdv']) + 1;
    $req = $this->container->pdo->prepare("UPDATE scoreboard SET content=:content WHERE date=:now");
    $bool = $req->execute([
      ':content' => serialize($scoreboard),
      ':now' => date('Y-m-d')
    ]);
    return ($bool);
  }

  public function update_current_lead(RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    $id_lead = intval(htmlspecialchars($params['id_lead']));
    $id_telepro = intval(htmlspecialchars($params['id_telepro']));

    $telepro = $this->container->pdo->query("
    SELECT options.content FROM user
    INNER JOIN options ON user.id=options.id_user
    WHERE user.type='telemarketing'")->fetchAll();
    foreach ($telepro as $k => $v)
    {
      $telepro[$k]['content'] = unserialize($v['content']);
      if ($telepro[$k]['content']['current_leads'])
      {
        foreach ($telepro[$k]['content']['current_leads'] as $key => $val)
          if ($key == $id_lead)
            unset($telepro[$k]['content']['current_leads'][$key]);
      }
      unset($telepro[$k][0]);
    }
    $req = $this->container->pdo->prepare("UPDATE options SET content=:content WHERE id_user=:id");
    $bool = $req->execute([
      ':content' => serialize($telepro),
      ':id' => $id_telepro
    ]);
    print_r($bool);
    return ($response);
  }

  public function get_scoreboard_information(RequestInterface $request, ResponseInterface $response, $args)
  {
    $req = $this->container->pdo->query("SELECT pseudo, avatar FROM user WHERE `type`='telemarketing'");
    $telepros = $req->fetchAll();
    $req = $this->container->pdo->prepare("SELECT signature_goal, rdv_goal, content FROM scoreboard WHERE date=:now");
    $req->execute([':now' => date('Y-m-d')]);
    $data = $req->fetchAll()[0];
    $content = unserialize($data['content']);
    foreach ($telepros as $k => $v)
    {
      $telepros[$k]['nbr_signature'] = $content[$v['pseudo']]['nbr_signature'];
      $telepros[$k]['nbr_rdv'] = $content[$v['pseudo']]['nbr_rdv'];
    }
    $telepros["score"] = [
      "signature_goal" => $data['signature_goal'],
      "rdv_goal" => $data['rdv_goal']
    ];
    if ($args['display'] == true)
      print_r(json_encode($telepros));
    return ($telepros);
  }

  public function update_max(RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams()['value'];
    $req = $this->container->pdo->prepare("UPDATE scoreboard SET signature_goal=:signature, rdv_goal=:rdv WHERE date=:now");
    $bool = $req->execute([
      ':signature' => intval(htmlspecialchars($params['signature'])),
      ':rdv' => intval(htmlspecialchars($params['rdv'])),
      ':now' => date('Y-m-d')
    ]);
    print_r($bool);
    return ($response);
  }

  public function update_signature_scoreboard(RequestInterface $request, ResponseInterface $response)
  {
    $scoreboard = $this->get_scoreboard_information($request, $response, null);
    $goal = $scoreboard['score'];
    unset($scoreboard['score']);
    return ($this->render($response, 'pages/update_signature.twig', [
      "telepros" => $scoreboard,
      "goal" => $goal
    ]));
  }

  public function update_signature_telepro(RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    $req = $this->container->pdo->prepare("SELECT id, content FROM scoreboard WHERE date=:now");
    $req->execute([
      ':now' => date('Y-m-d')
    ]);
    $data_scoreboard = $req->fetchAll()[0];
    $scoreboard = unserialize($data_scoreboard['content']);
    foreach ($scoreboard as $k => $v)
      if ($k == $params['pseudo'])
        $scoreboard[$k]['nbr_signature'] = $params['val'];
    $req = $this->container->pdo->prepare("UPDATE scoreboard SET content=:content WHERE id=:id");
    $bool = $req->execute([
      ':content' => serialize($scoreboard),
      ':id' => $data_scoreboard['id']
    ]);
    ($bool) ? print_r("success update") : print_r("error update");
    return ($response);
  }

  public function get_scoreboard(RequestInterface $request, ResponseInterface $response)
  {
    $req = $this->container->pdo->query("SELECT content FROM configuration WHERE type='scoreboard'");
    $data = unserialize($req->fetchAll()[0]['content']);
    return ($this->render($response, 'pages/scoreboard.twig', [
      "scoreboard" => [
        'color' => [
          'rdv' => $data['color_scoreboard_rdv'],
          'signature' => $data['color_scoreboard_signature']
        ]
      ]
    ]));
  }

  public function set_one_lead(RequestInterface $request, ResponseInterface $response, $args)
  {
    $params = $request->getParams();
    $req = $this->container->pdo->prepare("SELECT code_postal FROM client WHERE id=:id");
    $req->execute([':id' => htmlspecialchars($params['info']['id_lead'])]);
    $cp = substr($req->fetchAll()[0]['code_postal'], 0, 2);
    $region = $this->get_region($cp);
    $req = $this->container->pdo->prepare("SELECT content FROM agenda WHERE semaine=:semaine AND region=:region");
    $req->execute([
      ':semaine' => htmlspecialchars($params['info']['semaine']),
      ':region' => $region
    ]);
    $agenda = unserialize($req->fetchAll()[0]['content']);
    $horaire = explode('-', htmlspecialchars($params['horaire']));
    $horaire[1] = (count($horaire) > 2) ? $horaire[1] . "-" . $horaire[2] : $horaire[1];
    foreach ($agenda as $k => $v)
      if ($k == $horaire[0])
        $agenda[$k][$horaire[1]] = $agenda[$k][$horaire[1]] + 1;
    $req = $this->container->pdo->prepare("UPDATE agenda SET content=:content WHERE semaine=:semaine AND region=:region");
    $req->execute([
      ':content' => serialize($agenda),
      ':semaine' => htmlspecialchars($params['info']['semaine']),
      ':region' => $region
    ]);
    $params['info']['horaire'] = $horaire[1];
    $params['info']['date'] = $this->get_day_from_week($params['info']['semaine'], date('Y'), $horaire[0]);
    $req = $this->container->pdo->prepare("INSERT INTO traitement
      (id_telepro, id_lead, statut, content, created_at)
      VALUES (:id_telepro, :id_lead, :statut, :content, :created_at)");
    $req->execute([
      ':id_telepro' => intval(htmlspecialchars($params['info']['id_telepro'])),
      ':id_lead' => intval(htmlspecialchars($params['info']['id_lead'])),
      ':statut' => 5,
      ':content' => serialize($params['info']),
      ':created_at' => date('Y-m-d')
    ]);
    $req = $this->container->pdo->prepare("SELECT content FROM options WHERE id_user=:id");
    $req->execute([':id' => htmlspecialchars($params['info']['id_telepro'])]);
    $content = unserialize($req->fetchAll()[0]['content']);
    $id_lead = intval(htmlspecialchars($params['info']['id_lead']));
    foreach ($content['current_leads'] as $k => $v)
      if ($k == $id_lead)
        unset($content['current_leads'][$k]);
    $req = $this->container->pdo->prepare("UPDATE options SET content=:content WHERE id_user=:id");
    $req->execute([':content' => serialize($content), ':id' => htmlspecialchars($params['info']['id_telepro'])]);
    var_dump($this->add_rdv(intval(htmlspecialchars($params['info']['id_telepro'])), $request, $response));
    return ($response);
  }

  public function cant_continue(RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    if (isset($params['id_lead']) && isset($params['id_telepro']) && isset($params['statut']))
    {
      $id_client = intval(htmlspecialchars($params['id_lead']));
      $id_telepro = intval(htmlspecialchars($params['id_telepro']));
      $statut = intval(htmlspecialchars($params['statut']));
      $req = $this->container->pdo->prepare("UPDATE info_client SET disponible=:dispo WHERE id_client=:id");
      $req->execute([':dispo' => 0, ':id' => $id_client]);
      $req = $this->container->pdo->prepare("INSERT INTO
        traitement (id_telepro, id_lead, statut, content, created_at)
        VALUES (:id_telepro, :id_lead, :statut, :content, :created_at)");
      $req->execute([
        ':id_telepro' => $id_telepro,
        ':id_lead' => $id_client,
        ':statut' => $statut,
        ':content' => "",
        ':created_at' => date('Y-m-d')
      ]);
      $req = $this->container->pdo->prepare("SELECT content FROM options WHERE id_user=:id");
      $req->execute([':id' => $id_telepro]);
      $content = unserialize($req->fetchAll()[0]['content']);
      unset($content['current_leads'][$id_client]);
      $req = $this->container->pdo->prepare("UPDATE options SET content=:content WHERE id_user=:id");
      $req->execute([
        ':content' => serialize($content),
        ':id' => $id_telepro
      ]);
    }
    return ($response);
  }

  public function get_one_lead(RequestInterface $request, ResponseInterface $response, $args)
  {
    $req = $this->container->pdo->prepare("SELECT * FROM client INNER JOIN info_client ON client.id=info_client.id_client WHERE client.id=:id");
    $req->execute([':id' => htmlspecialchars($args['id'])]);
    $data = $req->fetchAll()[0];
    preg_match_all("/\d{2}+/", $data['telephone'], $output);
    $data['telephone'] = implode(" ", $output[0]);
    $this->render($response, 'pages/telepro-one-lead.twig', [
      'lead' => $data,
      'id' => [
        'lead' => $args['id'],
        'telepro' => $_SESSION['id']
      ]
    ]);
    return ($response);
  }

  public function get_agenda(RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    if (isset($params['code_postal']))
    {
      $cp = intval(htmlspecialchars(substr($params['code_postal'], 0, 2)));
      $region = $this->get_region($cp);
      $semaine = (isset($params['semaine'])) ? intval(htmlspecialchars($params['semaine'])) : intval(date('W'));
      if ($region)
      {
        $req = $this->container->pdo->prepare("SELECT content FROM agenda WHERE region=:region AND semaine=:semaine");
        $bool = $req->execute([
          ':region' => $region,
          ':semaine' => $semaine
        ]);
        if ($bool)
        {
          $data = unserialize($req->fetchAll()[0]['content']);
          $date = $this->get_day_from_week($semaine, date('Y'), "lundi");
          $get_week = date('Y-m-d', strtotime("+3 days", strtotime($date)));
          $date = explode('-', $date); $get_week = explode('-', $get_week);
          $data['date'] = $date[2] . "/" . $date[1] . " au " . $get_week[2] . "/" . $get_week[1];
          $data['semaine'] = $semaine;
          print_r(json_encode($data));
        }
      }
    }
    return ($response);
  }

  public function get_one_lead_id(RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    $id = intval(htmlspecialchars($params['id']));
    $req = $this->container->pdo->prepare("
    SELECT * FROM client
    INNER JOIN traitement ON client.id=traitement.id_lead
    INNER JOIN user ON traitement.id_telepro=user.id
    INNER JOIN info_client ON info_client.id_client=client.id
    WHERE client.id = :id");
    $bool = $req->execute([
      ':id' => $id
    ]);
    $data = $req->fetchAll()[0];
    $data['content'] = unserialize($data['content']);
    print_r(json_encode($data));
    return ($response);
  }

  public function display_agenda(RequestInterface $request, ResponseInterface $response)
  {
    $req = $this->container->pdo->prepare("
    SELECT client.nom, client.created_at, client.id, traitement.statut
    FROM traitement
    INNER JOIN client
    ON traitement.id_lead = client.id
    WHERE traitement.statut=:num1 OR traitement.statut=:num2 OR traitement.statut=:num3");
    $req->execute([':num1' => 5, ':num2' => 6, ':num3' => 7]);
    return ($this->render($response, 'pages/display_agenda.twig', [
      'leads' => $req->fetchAll()
    ]));
  }

  public function display_current_leads(RequestInterface $request, ResponseInterface $response)
  {
    $id_telepro = $this->container->pdo->query("SELECT id, pseudo FROM user WHERE type='telemarketing'")->fetchAll();
    $lead_telepro = [];
    foreach ($id_telepro as $k => $v)
    {
      $lead_telepro[$v['pseudo']] = $this->get_current_lead($v['id']);
      $lead_telepro[$v['pseudo']]['id_telepro'] = $v['id'];
    }
    return ($this->render($response, 'pages/display_current_leads.twig', [
      'leads' => $lead_telepro
    ]));
  }

  private function sort_statistiques_telepro($traitement, $to_json = false)
  {
    $ret['total'] = [
      'pas_interesser' => 0,
      'non_financeable' => 0,
      'hors_critere' => 0,
      'fausse_annonce' => 0,
      'rendez_vous' => 0,
      'signature' => 0,
      'total' => 0,
      'transformation_rdv' => 0,
      'transformation_signature' => 0
    ];
    $add = false;
    foreach ($traitement as $k => $v)
    {
      if (!isset($ret[$v['id_telepro']]))
      {
        $data = $this->container->pdo->prepare("SELECT id, pseudo FROM user WHERE id=:id");
        $data->execute([':id' => $v['id_telepro']]);
        $ret[$v['id_telepro']] = [
          'value' => [
            'pas_interesser' => 0,
            'non_financeable' => 0,
            'hors_critere' => 0,
            'fausse_annonce' => 0,
            'rendez_vous' => 0,
            'signature' => 0,
            'total' => 0,
            'transformation_rdv' => 0,
            'transformation_signature' => 0
          ],
          'name' => $data->fetchAll()[0]['pseudo'],
        ];
      }
      switch (intval($v['statut']))
      {
        case 1:
          $ret[$v['id_telepro']]['value']['pas_interesser'] = $ret[$v['id_telepro']]['value']['pas_interesser'] + 1;
          $add = true;
          break;
        case 2:
          $ret[$v['id_telepro']]['value']['non_financeable'] = $ret[$v['id_telepro']]['value']['non_financeable'] + 1;
          $add = true;
          break;
        case 3:
          $ret[$v['id_telepro']]['value']['hors_critere'] = $ret[$v['id_telepro']]['value']['hors_critere'] + 1;
          $add = true;
          break;
        case 4:
          $ret[$v['id_telepro']]['value']['fausse_annonce'] = $ret[$v['id_telepro']]['value']['fausse_annonce'] + 1;
          $add = true;
          break;
        case 5:
          $ret[$v['id_telepro']]['value']['rendez_vous'] = $ret[$v['id_telepro']]['value']['rendez_vous'] + 1;
          $add = true;
          break;
        case 6:
          $ret[$v['id_telepro']]['value']['signature'] = $ret[$v['id_telepro']]['value']['signature'] + 1;
          $add = true;
          break;
        case 7:
          $ret[$v['id_telepro']]['value']['signature'] = $ret[$v['id_telepro']]['value']['signature'] + 1;
          $add = true;
          break;
        case 8:
          $ret[$v['id_telepro']]['value']['signature'] = $ret[$v['id_telepro']]['value']['signature'] + 1;
          $add = true;
          break;
      }
      if ($add)
        $ret[$v['id_telepro']]['value']['total'] = $ret[$v['id_telepro']]['value']['total'] + 1;
      $add = false;
    }
    $count = 0;
    foreach ($ret as $k => $v)
    {
      if ($k != "total")
      {
        $count++;
        $ret[$k]['value']['transformation_rdv'] = round(($ret[$k]['value']['rendez_vous'] * 100) / $ret[$k]['value']['total'], 2);
        $ret[$k]['value']['transformation_signature'] = round(($ret[$k]['value']['signature'] * 100) / $ret[$k]['value']['total'], 2);
        $ret['total']['pas_interesser'] = $ret['total']['pas_interesser'] + $ret[$k]['value']['pas_interesser'];
        $ret['total']['non_financeable'] = $ret['total']['non_financeable'] + $ret[$k]['value']['non_financeable'];
        $ret['total']['hors_critere'] = $ret['total']['hors_critere'] + $ret[$k]['value']['hors_critere'];
        $ret['total']['fausse_annonce'] = $ret['total']['fausse_annonce'] + $ret[$k]['value']['fausse_annonce'];
        $ret['total']['rendez_vous'] = $ret['total']['rendez_vous'] + $ret[$k]['value']['rendez_vous'];
        $ret['total']['signature'] = $ret['total']['signature'] + $ret[$k]['value']['signature'];
        $ret['total']['total'] = $ret['total']['total'] + $ret[$k]['value']['total'];
        $ret['total']['transformation_rdv'] = round(($ret['total']['transformation_rdv'] + $ret[$k]['value']['transformation_rdv']) / $count, 2);
        $ret['total']['transformation_signature'] = round(($ret['total']['transformation_signature'] + $ret[$k]['value']['transformation_signature']) / $count, 2);
      }
    }
    if ($to_json)
      return (json_encode($ret));
    return ($ret);
  }

  public function reinject_lead (RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    if (isset($params['id_lead']))
    {
      $id_leads = explode(';', $params['id_lead']);
      $request = "UPDATE traitement SET reinject=:bool WHERE";
      $exec[':bool'] = 1;
      for ($i = 0; $i < count($id_leads); $i++)
      {
        $request .= " id_lead=:id_" . $i . " OR ";
        $exec[':id_' . $i] = $id_leads[$i];
      }
      $request = substr($request, 0, strlen($request) - 4);
      $req = $this->container->pdo->prepare($request);
      $bool = $req->execute($exec);
      print_r($bool);
    }
    return ($response);
  }

  public function import_leads(RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    if (isset($params['id']) && isset($params['type']))
    {
      $statut = intval(htmlspecialchars($params['type']));
      $id = intval(htmlspecialchars($params['id']));
      $data = array();
      $date = explode('|', htmlspecialchars($params['date']));
      $request = "SELECT * FROM traitement
      INNER JOIN client ON traitement.id_lead = client.id
      INNER JOIN info_client ON traitement.id_lead = info_client.id_client WHERE traitement.id_telepro=:id AND traitement.reinject=:val";
      if ($date[0] != "_")
      {
        $request .= (count($date) > 1) ? " AND created_at BETWEEN :date1 AND :date2" : " AND created_at=:date1";
        $exec = (count($date) > 1) ? [':id' => $id, ':date1' =>  $date[0], ':date2' => $date[1]] : [':id' => $id, ':date1' =>  $date[0]];
      }
      else
        $exec = [':id' => $id];
      if ($statut == 6)
      {
        $request_archives = "SELECT content FROM archives_leads WHERE id_telepro=:id";
        if ($date[0] != "_")
        {
          $request_archives .= (count($date) > 1) ? " AND created_at BETWEEN :date1 AND :date2" : " AND created_at=:date1";
          $exec = (count($date) > 1) ? [':id' => $id, ':date1' =>  $date[0], ':date2' => $date[1]] : [':id' => $id, ':date1' =>  $date[0]];
        }
        else
          $exec = [':id' => $id];
        $req = $this->container->pdo->prepare($request_archives);
        $req->execute($exec);
        $data = $req->fetchAll();
        foreach ($data as $k => $v)
        {
          $data[$k] = unserialize($v['content']);
          $data[$k]['content'] = unserialize($data[$k]['content']);
        }
        $request .= " AND (traitement.statut=:statut1 OR traitement.statut=:statut2)";
        $exec[':statut1'] = 6; $exec[':statut2'] = 7; $exec[':val'] = 0;
      }
      else
      {
        $request .= " AND traitement.statut=:statut";
        $exec[':statut'] = $statut; $exec[':val'] = 0;
      }
      $req = $this->container->pdo->prepare($request);
      $req->execute($exec);
      $sec_data = $req->fetchAll();
      foreach ($sec_data as $k => $v)
        $sec_data[$k]['content'] = unserialize($v['content']);
      print_r(json_encode(array_merge($data, $sec_data)));
    }
    return ($response);
  }

  public function show_statistiques(RequestInterface $request, ResponseInterface $response)
  {
    $traitement = $this->container->pdo->query("SELECT * FROM traitement")->fetchAll();
    return ($this->render($response, 'pages/telepro_statistiques.twig', ['telepros' => $this->sort_statistiques_telepro($traitement)]));
  }

  public function get_statistiques(RequestInterface $request, ResponseInterface $response, $args)
  {
    if (isset($args['name']) && isset($args['date']))
    {
      if ($args['name'] == "all")
        $req = "SELECT * FROM traitement WHERE ";
      else
      {
        $req = "SELECT * FROM traitement WHERE id_telepro=:id AND ";
        $exec[':id'] = intval(htmlspecialchars($args['name']));
      }
      $date = explode('|', $args['date']);
      if (count($date) == 1)
      {
        $req = $req . "created_at=:date";
        $exec[':date'] = htmlspecialchars($date[0]);
      }
      else
      {
        $req = $req . "created_at BETWEEN :date1 AND :date2";
        $exec[':date1'] = htmlspecialchars($date[0]);
        $exec[':date2'] = htmlspecialchars($date[1]);
      }
      $request = $this->container->pdo->prepare($req);
      $request->execute($exec);
      print_r($this->sort_statistiques_telepro($request->fetchAll(), true));
      return ($response);
    }
    else
      return ($repsonse);
  }

  public function confirm_rdv(RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();

    if (isset($params['id']))
    {
      $id = intval(htmlspecialchars($params['id']));
      $req = $this->container->pdo->prepare("UPDATE traitement SET statut=:num WHERE id_lead=:id");
      $bool = $req->execute([
        ':num' => 6,
        ':id' => $id
      ]);
      print_r($bool);
    }
  }

  public function traitement_lead (RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();

    if (isset($params['id_lead']))
    {
      $id_lead = intval($params['id_lead']);
      $req = $this->container->pdo->prepare("UPDATE traitement SET statut='7' WHERE id_lead=:id");
      $bool = $req->execute([':id' => $id_lead]);
      print_r($bool);
    }
    return ($response);
  }

  public function archive_lead(RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();

    if (isset($params['id_lead']))
    {
      $id_lead = intval(htmlspecialchars($params['id_lead']));
      $id_telepro = intval(htmlspecialchars($params['id_telepro']));
      $req = $this->container->pdo->prepare("
        SELECT * FROM traitement
        INNER JOIN client ON traitement.id_lead=client.id
        INNER JOIN info_client ON traitement.id_lead=info_client.id_client
        WHERE traitement.id_lead=:id
      ");
      $req->execute([':id' => $id_lead]);
      $data = serialize($req->fetchAll()[0]);
      $req = $this->container->pdo->prepare("
      INSERT INTO archives_leads (id_lead, id_telepro, content, statut, created_at)
      VALUES (:id_lead, :id_telepro, :content, :statut, :created_at)");
      $bool = $req->execute([
        ':id_lead' => $id_lead,
        ':id_telepro' => $id_telepro,
        ':content' => $data,
        ':statut' => 8,
        ':created_at' => date('Y-m-d')
      ]);
      if ($bool)
      {
        $req = $this->container->pdo->prepare("UPDATE traitement SET statut=8 WHERE id_lead=:id");
        $req->execute([':id' => $id_lead]);
        $req = $this->container->pdo->prepare("DELETE FROM client WHERE id=:id");
        $req->execute([':id' => $id_lead]);
        $req = $this->container->pdo->prepare("DELETE FROM info_client WHERE id_client=:id");
        $req->execute([':id' => $id_lead]);
      }
      print_r($bool);
    }
    else
      print_r("non id setup");
    return ($response);
  }

  public function display_one_lead(RequestInterface $request, ResponseInterface $response, $args)
  {
    $req = $this->container->pdo->prepare("SELECT nom, prenom FROM client WHERE id=:id");
    $req->execute([':id' => intval($args['id_lead'])]);
    print_r(json_encode($req->fetchAll()[0]));
    return ($response);
  }

  public function display_date(RequestInterface $request, ResponseInterface $response, $args)
  {
    $req = $this->container->pdo->prepare("
    SELECT * FROM traitement
    INNER JOIN client ON traitement.id_lead = client.id
    WHERE traitement.id_telepro=:id
    ");
    $ret = $req->fetchAll()[0];
    $req->execute([':id' => intval($args['id_telepro'])]);
    return ($this->render($response, 'pages/display_date.twig', [
      'dates' => $ret,
    ]));
  }

  public function validate_lead (RequestInterface $request, ResponseInterface $response)
  {
    $req = $this->container->pdo->prepare("
    SELECT client.nom, client.created_at, client.id, traitement.statut
    FROM traitement
    INNER JOIN client
    ON traitement.id_lead = client.id
    WHERE (traitement.statut=:num1 OR traitement.statut=:num2) AND traitement.id_telepro=:telepro");
    $req->execute([':num1' => 5, ':num2' => 6, ':telepro' => $_SESSION['id']]);
    return ($this->render($response, 'pages/validate_lead.twig', [
      'leads' => $req->fetchAll()
    ]));
  }

  public function index (RequestInterface $request, ResponseInterface $response)
  {
    $req = $this->container->pdo->prepare("SELECT lead_color FROM options WHERE id_user=:id");
    $req->execute([':id' => $_SESSION['id']]);
    return ($this->render($response, 'pages/telepro.twig', [
      'current_leads' => $this->get_current_lead(undefined),
      'user' => [
        'lead_color' => $req->fetchAll()[0]['lead_color'],
        'id' => $_SESSION['id']
      ]
    ]));
  }

}

?>
