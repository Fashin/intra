<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Controller
{
  protected $container;

  private $protect_page = [
    'telemarketing' => [
      'PagesTelepro', 'PagesUsers', 'PagesLeads'
    ],
    'admin' => [
      'PagesDashboard', 'PagesLeads', 'PagesFactures', 'PagesUsers', 'PagesTelepro', 'PagesLeads', 'PagesArchives'
    ],
    'super_admin' => [
      'PagesAdmin', 'PagesDashboard', 'PagesLeads', 'PagesFactures', 'PagesUsers', 'PagesTelepro', 'PagesLeads', 'PagesArchives'
    ]
  ];

  function __construct($container)
  {
    $this->container = $container;
  }

  private function is_admin()
  {
    if ($_SESSION['type'] == 'super_admin' || $_SESSION['type'] == 'admin')
      return (true);
    return (false);
  }

  private function check_connexion()
  {
    $child = explode('\\', get_called_class())[2];

    if (!(isset($_SESSION['type'])) && $child == 'PagesUsers')
      return (true);
    if (in_array($child, $this->protect_page[$_SESSION['type']]))
      return (true);
    return (false);
  }

  protected function render(ResponseInterface $response, $page, $params = [])
  {
    if (!$this->check_connexion())
      return ($response->withRedirect('/'));
    else
      $this->container->view->render($response, $page, $params);
    return ($response);
  }

  protected function __getdev()
  {
    return ($this->container->dev);
  }

  protected function redirect_api($response, $name, $method = "GET")
  {
    return $response
              ->withHeader('Access-Control-Allow-Origin', "http://$name")
              ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
              ->withHeader('Access-Control-Allow-Methods', $method);
  }
}


?>
