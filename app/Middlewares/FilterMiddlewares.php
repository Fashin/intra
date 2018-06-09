<?php

namespace App\Middlewares;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class FilterMiddlewares
{
  private $auth_request = ['/archives'];

  public function __invoke(RequestInterface $request, ResponseInterface $response, $next)
  {
    $way = $request->getUri()->getPath();
    $response = $next($request, $response);
    return ($response);
  }
}

?>
