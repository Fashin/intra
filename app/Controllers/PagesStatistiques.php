<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesStatistiques extends Controller
{
  private $filter_func = [
    "visiteur" => "sort_statistiques",
    "leads" => "sort_client",
    "transformation" => "sort_mixed"
  ];

  private function get_diff($date_range)
  {
    $diff = abs(strtotime($date_range[0]) - strtotime($date_range[1]));
    $year = floor($diff / 31536000);
    $month = floor(($diff - $year * 31536000) / (2592000));
    $day = floor(($diff - $year * (31536000) - $month * (2592000)) / (86400));
    return ($day);
  }

  private function convert_data ($data, $date_range)
  {
    $ret = array();
    $save = 86400;
    $max = $this->get_diff($date_range);
    $time = strtotime($date_range[1]);
    $tmp = array();
    foreach ($data as $k => $v)
    {
      if (!array_key_exists($v['site'], $tmp))
        $tmp[$v['site']] = 1;
      $last_day = 0;
      if (!isset($ret[$v['site']]))
      {
        for ($i = $max; $i > 0; $i--)
        {
          $ret[$v['site']][date('Y-m-d', $time - $last_day)] = 0;
          $last_day = $last_day + $save;
        }
      }
      else
        $ret[$v['site']][$v['created_at']] = $ret[$v['site']][$v['created_at']] + 1;
    }
    $new = array();
    foreach ($ret as $k => $v)
    {
      $key = array_keys($v);
      usort($key, function ($a, $b) {
        return (strtotime($a) - strtotime($b));
      });
      $new[$k]['values'] = array_values(array_combine($key, array_reverse($v)));
      $new['label'] = array_map(function ($date) {
        return (date('m-d-Y', strtotime($date)));
      }, $key);
    }
    return (json_encode($new));
  }

  private function sort_mixed($campagnes_name, $date_range)
  {
    $campagnes = explode('|', $campagnes_name);
    $ret = "WHERE (";
    $exec = array();
    foreach ($campagnes as $k => $v)
    {
      $ret = $ret . "site=:site". $k. " OR ";
      $exec[":site" . $k ] = $v;
    }
    $ret = substr($ret, 0, strlen($ret) - 4) . ")";
    $req = $this->container->pdo->prepare("SELECT site, created_at FROM statistiques " . $ret. " AND (created_at BETWEEN :start_date AND :end_date)");
    $exec[':start_date'] = $date_range[0];
    $exec[':end_date'] = $date_range[1];
    $req->execute($exec);
    $stat = json_decode($this->convert_data($req->fetchAll(), $date_range), true);
    $req = $this->container->pdo->prepare("SELECT site, created_at FROM client " . $ret. " AND (created_at BETWEEN :start_date AND :end_date)");
    $req->execute($exec);
    $client = json_decode($this->convert_data($req->fetchAll(), $date_range), true);
    $ret = array();
    $ret['label'] = $stat['label'];
    unset($stat['label']); unset($client['label']);
    foreach ($stat as $k => $v)
      $ret[$k]['stat'] = $v['values'];
    foreach ($client as $k => $v)
      $ret[$k]['client'] = $v['values'];
    $max = $this->get_diff($date_range);
    foreach ($ret as $k => $v)
    {
      if (isset($v['stat']) && isset($v['client']))
      {
        for ($i = 0; $i < count($v['stat']); $i++)
        {
          if ($v['stat'][$i] > 0 && $v['client'][$i] > 0)
            $ret[$k]['values'][$i] = round(($v['client'][$i] / $v['stat'][$i]) * 100, 2);
          else
            $ret[$k]['values'][$i] = 0;
        }
        unset($ret[$k]['stat']); unset($ret[$k]['client']);
      }
      else if (key($v) != "label")
        for ($i = 0; $i > $max; $i++)
          $ret[$k]['values'][] = 0;
    }
    return (json_encode($ret));
  }

  private function sort_client($campagnes_name, $date_range)
  {
    $campagnes = explode('|', $campagnes_name);
    $ret = "WHERE (";
    $exec = array();
    foreach ($campagnes as $k => $v)
    {
      $ret = $ret . "site=:site". $k. " OR ";
      $exec[":site" . $k ] = $v;
    }
    $ret = substr($ret, 0, strlen($ret) - 4) . ")";
    $req = $this->container->pdo->prepare("SELECT site, created_at FROM client " . $ret. " AND (created_at BETWEEN :start_date AND :end_date)");
    $exec[':start_date'] = $date_range[0];
    $exec[':end_date'] = $date_range[1];
    $req->execute($exec);
    $data = $req->fetchAll();
    return $this->convert_data($data, $date_range);
  }

  private function sort_statistiques($campagnes_name, $date_range)
  {
    $campagnes = explode('|', $campagnes_name);
    $ret = "WHERE (";
    $exec = array();
    foreach ($campagnes as $k => $v)
    {
      $ret = $ret . "site=:site". $k. " OR ";
      $exec[":site" . $k ] = $v;
    }
    $ret = substr($ret, 0, strlen($ret) - 4) . ")";
    $req = $this->container->pdo->prepare("SELECT site, created_at FROM statistiques " . $ret . " AND (created_at BETWEEN :start_date AND :end_date)");
    $exec[':start_date'] = $date_range[0];
    $exec[':end_date'] = $date_range[1];
    $req->execute($exec);
    return $this->convert_data($req->fetchAll(), $date_range);
  }

  public function filter (RequestInterface $request, ResponseInterface $response, $args)
  {
    $filter = htmlspecialchars($args['filter']);
    $filter = array_filter(explode('_', $filter));
    $func = $this->filter_func[$filter[1]];
    print_r($this->$func($filter[0], explode('@', $filter[2])));
    return ($response);
  }

  public function save_statistiques(RequestInterface $request, ResponseInterface $response)
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
    $req = $this->container->pdo->prepare(
      'INSERT INTO statistiques
      (region_name, city, zip_code, created_at, site, page, ip)
      VALUES (:region_name, :city, :zip_code, :created_at, :site, :page, :ip)');
    $bool = $req->execute(array(
      ':region_name' => htmlspecialchars($params['info']['region_name']),
      ':city' => htmlspecialchars($params['info']['city']),
      ':zip_code' => htmlspecialchars($params['info']['zip_code']),
      ':created_at' => date('Y-m-d'),
      ':site' => $name,
      ':page' => htmlspecialchars($params['page']),
      ':ip' => htmlspecialchars($params['info']['ip'])
    ));
    if (!$bool)
      return (NULL);
    return ($this->redirect_api($response, $name, 'POST'));
  }

  public function index (RequestInterface $request, ResponseInterface $response)
  {
    $this->render($response, 'pages/statistiques.twig', [
      'campagnes' => $this->container->pdo->query("SELECT name FROM site")->fetchAll()
    ]);
    return ($response);
  }
}

?>
