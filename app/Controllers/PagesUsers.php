<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesUsers extends Controller
{
  private $oauth_params_update_password = ['new_password', 'new_password_confirm', 'old_password', 'send'];

  private function get_all_options()
  {
    $req = $this->container->pdo->prepare("SELECT * FROM user INNER JOIN options ON user.id=options.id_user WHERE user.id=:id");
    $req->execute([':id' => $_SESSION['id']]);
    $ret = $req->fetchAll()[0];
    $ret = array(
      'pseudo' => $ret['pseudo'],
      'type' => $ret['type'],
      'id' => $ret['id'],
      'content' => unserialize($ret['content']),
    );
    return ($ret);
  }

  public function user_options (RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    if (!empty($params))
    {
      foreach ($params as $k => $v)
        if (!in_array($k, $this->oauth_params_update_password))
          return ($response->withRedirect('/'));
      if ($params['new_password'] == $params['new_password_confirm'])
      {
        $req = $this->container->pdo->prepare('SELECT id FROM user WHERE id=:id AND password=:password');
        $req->execute([
          ':id' => $_SESSION['id'],
          ':password' => hash('whirlpool', $params['old_password'])
        ]);
        if (!empty($req->fetchAll()[0]['id']))
        {
          $req = $this->container->pdo->prepare('UPDATE user SET password=:password WHERE id=:id');
          $req->execute([
            ':password' => hash('whirlpool', $params['new_password']),
            ':id' => $_SESSION['id']
          ]);
          return ($response->withRedirect('/parametres'));
        }
        else
          return ($response->withRedirect('/parametres'));
      }
      else
        return ($response->withRedirect('/parametres'));
    }
    else
    {
      if ($_SESSION['type'] == "telemarketing")
      {
        $req = $this->container->pdo->prepare("SELECT lead_selection, lead_color, lead_rappel FROM options WHERE id_user=:id");
        $req->execute([':id' => $_SESSION['id']]);
        $data = $req->fetchAll()[0];
        $this->render($response, 'pages/personnal_options.twig', [
          'type' => $_SESSION['type'],
          'user' => [
            'id' => $_SESSION['id'],
            'lead_selection' => $data['lead_selection'],
            'lead_color' => $data['lead_color'],
            'lead_rappel' => $data['lead_rappel']
          ]
        ]);
      }
      else
      {
        $req = $this->container->pdo->query("SELECT content FROM configuration WHERE type='scoreboard'");
        $data = $req->fetchAll()[0]['content'];
        if ($data == NULL)
        {
          $color_rdv = "#0066cc";
          $color_signature = "#d1009c";
        }
        else
        {
          $data = unserialize($data);
          $color_rdv = $data['color_scoreboard_rdv'];
          $color_signature = $data['color_scoreboard_signature'];
        }
        $this->render($response, 'pages/personnal_options.twig', [
          'type' => $_SESSION['type'],
          'configuration' => [
            'scoreboard' => [
              'rdv' => $color_rdv,
              'signature' => $color_signature
            ]
          ]
        ]);
      }
    }
  }

  public function set_color(RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    $oauth_table = ['lead_selection', 'lead_color', 'lead_rappel'];
    if (isset($params['row']) && isset($params['value']))
    {
      if (in_array($params['row'], $oauth_table))
      {
        $value = htmlspecialchars($params['value']);
        $row = htmlspecialchars($params['row']);
        $req = $this->container->pdo->prepare("UPDATE options SET " . $row . "=:value WHERE id_user=:id");
        $bool = $req->execute([':value' => $value, ':id' => $_SESSION['id']]);
        var_dump($bool);
      }
    }
    return ($response);
  }

  public function set_color_scoreboard (RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    $req = $this->container->pdo->query("SELECT content FROM configuration WHERE type='scoreboard'");
    $data = unserialize($req->fetchAll()[0]['content']);
    if ($data == NULL || $data == false)
    {
      $color_scoreboard_rdv = "#0066cc";
      $color_scoreboard_signature = "#d1009c";
    }
    else
    {
      $color_scoreboard_rdv = $data['color_scoreboard_rdv'];
      $color_scoreboard_signature = $data['color_scoreboard_signature'];
    }
    $color_scoreboard_rdv = (isset($params['color_scoreboard_rdv'])) ? htmlspecialchars($params['color_scoreboard_rdv']) : $color_scoreboard_rdv;
    $color_scoreboard_signature =  (isset($params['color_scoreboard_signature'])) ? htmlspecialchars($params['color_scoreboard_signature']) : $color_scoreboard_signature;
    $data['color_scoreboard_rdv'] = $color_scoreboard_rdv;
    $data['color_scoreboard_signature'] = $color_scoreboard_signature;
    $req = $this->container->pdo->prepare("UPDATE configuration SET content=:content WHERE type=:type");
    $bool = $req->execute([
      ':content' => serialize($data),
      ':type' => "scoreboard"
    ]);
    var_dump($bool);
    return ($response);
  }

  public function save_options (RequestInterface $request, ResponseInterface $response, $args)
  {
    $new_content = $request->getParams();
    $req = $this->container->pdo->prepare('UPDATE options SET content=:content WHERE id=:id');
    $req->execute([
      ':content' => serialize($new_content),
      ':id' => $args['id']
    ]);
    return ($response->withRedirect('/factures'));
  }

  public function update_avatar(RequestInterface $request, ResponseInterface $response)
  {
    $file = $request->getUploadedFiles();
    if (!empty($file['avatar']))
    {
      $file = $file['avatar'];
      if ($file->getError() == UPLOAD_ERR_OK)
      {
        $upload_path = __DIR__ . "/../../public/img/avatar/";
        $name = $file->getClientFilename();
        $uid = uniqid("", true);
        $path = $upload_path . $uid . $name;
        $file->moveTo($path);
        $req = $this->container->pdo->prepare("UPDATE user SET avatar=:path_to_avatar WHERE id=:id");
        $bool = $req->execute([
          ':path_to_avatar' => "img/avatar/" . $uid . $name,
          ':id' => $_SESSION['id']
        ]);
        print_r($bool);
        return ($response->withRedirect('/parametres'));
      }
      else
        var_dump($file->getError());
    }
    return ($response);
  }

  public function get_color(RequestInterface $request, ResponseInterface $response, $args)
  {
    $id_user = intval(htmlspecialchars($args['id_user']));
    $req = $this->container->pdo->prepare("SELECT lead_selection, lead_rappel FROM options WHERE id_user=:id");
    $req->execute([':id' => $id_user]);
    print_r(json_encode($req->fetchAll()[0]));
    return ($response);
  }

  public function get_color_scoreboard(RequestInterface $request, ResponseInterface $response)
  {
    $req = $this->container->pdo->query("SELECT content FROM configuration WHERE type='scoreboard'");
    print_r(json_encode(unserialize($req->fetchAll()[0]['content'])));
    return ($response);
  }

  public function option_entreprise (RequestInterface $request, ResponseInterface $response)
  {
    $this->render($response, 'pages/user_options.twig', [
      'options' => $this->get_all_options(),
    ]);
    return ($response);
  }

  public function connexion (RequestInterface $request, ResponseInterface $response)
  {
    $this->render($response, 'pages/connexion.twig');
  }

  public function register_connexion (RequestInterface $request, ResponseInterface $response)
  {
    $params = $request->getParams();
    $req = $this->container->pdo->prepare('SELECT id, type FROM user WHERE pseudo=:pseudo AND password=:password');
    $bool = $req->execute([
      ':pseudo' => htmlspecialchars($params['pseudo']),
      ':password' => hash('whirlpool', htmlspecialchars($params['password']))
    ]);
    $ret = $req->fetchAll()[0];
    if (!empty($ret['id']))
    {
      $_SESSION['id'] = $ret['id'];
      $_SESSION['type'] = $ret['type'];
    }
    else
      return ($response->withRedirect('/'));

    if ($ret['type'] == 'admin' || $ret['type'] == 'super_admin')
      return ($response->withRedirect('/dashboard'));
    else
      return ($response->withRedirect('/telepro'));
  }

  public function logout (RequestInterface $request, ResponseInterface $response)
  {
    session_destroy();
    return ($response->withRedirect('/'));
  }

}

?>
