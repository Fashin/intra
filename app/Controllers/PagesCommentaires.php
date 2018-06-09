<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesCommentaires extends Controller
{

  public function new_commentaire (RequestInterface $request, ResponseInterface $response)
  {
    if (!(preg_match('#http:\/\/(.*)#', $_SERVER['HTTP_ORIGIN'], $match)))
      return (NULL);
    $req = $this->container->pdo->prepare('SELECT id, name FROM site WHERE name=:name');
    $req->execute([':name' => $match[1]]);
    $data = $req->fetchAll()[0];
    if (empty($data[0]))
      return (NULL);
    $params = $request->getParams();
    if (!isset($params['nom']) || !isset($params['value']))
      return (NULL);
    $name = (isset($params['nom'])) ? htmlspecialchars($params['nom']) : "Inconue";
    $name = (isset($params['prenom'])) ? " " . htmlspecialchars($params['prenom']) : " Anonyme";
    $req = $this->container->pdo->prepare(
      "INSERT INTO commentaire (nom, value, traitement, id_site, created_at)
      VALUES (:nom, :value, :traitement, :id_site, :created_at)");
    $bool = $req->execute([
      ':nom' => $name,
      ':value' => htmlspecialchars($params['value']),
      ':traitement' => 'en_cour',
      ':id_site' => intval($data["id"]),
      ':created_at' => date('Y-n-d H:i:s')
    ]);
    if (!$bool)
      return (NULL);
    return ($this->redirect_api($response, $data['name'], 'POST'));
  }

  public function get_commentaire (RequestInterface $request, ResponseInterface $response, $args)
  {
    if (!(preg_match('#http:\/\/(.*)#', $_SERVER['HTTP_ORIGIN'], $match)))
      return (NULL);
    $req = $this->container->pdo->prepare('SELECT id, name FROM site WHERE name=:name');
    $req->execute([':name' => $match[1]]);
    $data = $req->fetchAll()[0];
    if (empty($data[0]))
      return (NULL);
    if (!(isset($args['site_name'])))
      return (NULL);
    $req = $this->container->pdo->prepare(
      "SELECT commentaire.nom, commentaire.value, commentaire.created_at
      FROM commentaire INNER JOIN site
      WHERE commentaire.id_site = site.id AND site.name=:site_name AND commentaire.traitement=:traitement ORDER BY commentaire.id");
    $bool = $req->execute(['site_name' => htmlspecialchars($args['site_name']), ':traitement' => "live"]);
    if (!$bool)
      return (NULL);
    print_r(json_encode($req->fetchAll()));
    return ($this->redirect_api($response, $args['site_name']));
  }

  public function update_commentaire (RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    if (!isset($params['id']) && !isset($params['value']))
      return (NULL);
    $req = $this->container->pdo->prepare("UPDATE commentaire SET traitement=:traitement WHERE id=:id");
    $req->execute([
      ':traitement' => (intval(htmlspecialchars($params['value']))) ? "live" : "en_cour",
      ':id' => htmlspecialchars($params['id'])
    ]);
  }

  public function index (RequestInterface $request, ResponseInterface $response)
  {
    $this->render($response, "pages/commentaire.twig", [
      'commentaires' => $this->container->pdo->query("SELECT * FROM commentaire")
    ]);
    return ($response);
  }
}

?>
