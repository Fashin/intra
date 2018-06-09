<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesDashboard extends Controller
{
  private function get_all_sites()
  {
    return $this->container->pdo->query('SELECT name, link FROM site')->fetchAll();
  }

  private function get_statistiques()
  {
    $last_week = date("Y-m-d", strtotime('-1 week'));
    $req = $this->container->pdo->prepare('SELECT created_at FROM statistiques WHERE created_at BETWEEN :last_week AND NOW()');
    $req->execute([':last_week' => $last_week]);
    $req = $req->fetchAll();
    $ret = array(
      date('Y-m-d') => 0,
      date('Y-m-d', strtotime("-1 day")) => 0,
      date('Y-m-d', strtotime("-2 day")) => 0,
      date('Y-m-d', strtotime("-3 day")) => 0,
      date('Y-m-d', strtotime("-4 day")) => 0,
      date('Y-m-d', strtotime("-5 day")) => 0,
      date('Y-m-d', strtotime("-6 day")) => 0,
    );
    foreach ($req as $k => $v)
      $ret[$v['created_at']] = $ret[$v['created_at']] + 1;
    return (array_reverse($ret, true));
  }

  public function dashboard(RequestInterface $request, ResponseInterface $response)
  {
    $this->render($response, 'pages/dashboard.twig', [
      'sites' => $this->get_all_sites(),
      'statistiques' => $this->get_statistiques()
    ]);
  }
}


?>
