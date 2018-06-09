<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesArchives extends Controller
{
  private function filter ($date1, $date2 = null)
  {
    if ($date1 && $date2)
    {
      $req = "SELECT content FROM archives_leads WHERE created_at BETWEEN :date1 AND :date2";
      $exec[':date1'] = htmlspecialchars($date1);
      $exec[':date2'] = htmlspecialchars($date2);
    }
    else
    {
      $req = "SELECT content FROM archives_leads WHERE created_at=:created_at";
      $exec[':created_at'] = htmlspecialchars($date1);
    }
    $request = $this->container->pdo->prepare($req);
    $bool = $request->execute($exec);
    if ($bool)
    {
        $data = $request->fetchAll();
        foreach ($data as $k => $v)
        {
          $data[$k] = unserialize($v['content']);
          $data[$k]['content'] = unserialize($data[$k]['content']);
        }
        return ($data);
    }
    return (NULL);
  }

  public function view_one_lead(RequestInterface $request, ResponseInterface $response, $args)
  {
    $req = $this->container->pdo->prepare("SELECT content FROM archives_leads WHERE id_lead=:id");
    $bool = $req->execute([':id' => htmlspecialchars($args['id_lead'])]);
    if ($bool)
    {
        $data = $req->fetchAll()[0];
        $data = unserialize($data['content']);
        $req = $this->container->pdo->prepare("SELECT pseudo FROM user WHERE id=:id");
        $req->execute([':id' => $data['id_telepro']]);
        $data['nom_telepro'] = $req->fetchAll()[0]['pseudo'];
        $data['content'] = unserialize($data['content']);
        return ($this->render($response, 'pages/view_one_archive.twig', [
          'leads' => $data
        ]));
    }
    else
      return ($response);
  }

  public function index(RequestInterface $request, ResponseInterface $response, $args)
  {
    return ($this->render($response, 'pages/archives.twig', [
      'archives' => $this->filter(date('Y-m-d'))
    ]));
  }
}

?>
