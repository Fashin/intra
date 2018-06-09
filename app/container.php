<?php

  $container = $app->getContainer();

  $container['dev'] = function() {
    return (false);
  };

  $container['view'] = function ($container) {
    $dir = dirname(__DIR__);
    $view = new \Slim\Views\Twig($dir . '/app/views/', [
        'cache' => ($container->dev) ? false : $dir . '/tmp/cache',
        'debug' => ($container->dev) ? true : false
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
  };

  $container['pdo'] = function($container)
  {
    try {
      if ($container->dev)
      {
        $dbh = new PDO('mysql:host=localhost;dbname=os', 'root', 'Beauvois41');
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
      }
      else
        $dbh = new PDO('mysql:host=db714152564.db.1and1.com;dbname=db714152564', 'dbo714152564', '33iA4F^zi[');
    } catch (PDOException $e) {
      print "Erreur !: " . $e->getMessage() . "<br/>";
      die();
    }
    return $dbh;
  };

  $container['zip'] = function()
  {
    return (new ZipArchive());
  };

  $container['mail'] = function($container)
  {
    if ($container->dev)
      $transport = new Swift_SmtpTransport('localhost', 1025);
    else
    {
      $transport = (new Swift_SmtpTransport('smtp.1and1.com', 25))
                  ->setUsername('cyprian.beauvois@objectifsolaire.com')
                  ->setPassword('Beauvois41');
    }
    $mailer = new Swift_Mailer($transport);
    return ($mailer);
  };
?>
