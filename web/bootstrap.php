<?php
require_once __DIR__.'/../vendor/autoload.php';

use AGR\Entity\Post;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__.'/../views'
));

$paths = array(__DIR__. DIRECTORY_SEPARATOR . '../src/');
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '1234',
    'dbname'   => 'silex',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
$em = EntityManager::create($dbParams, $config);

$app['posts'] = function() {
  return array(
    new Post(1, "titulo post 1", "conteudo post de id 1"),
    new Post(2, "titulo post 2", "conteudo post de id 2"),
    new Post(3, "titulo post 3", "conteudo post de id 3"),
    new Post(4, "titulo post 4", "conteudo post de id 4"),
    new Post(5, "titulo post 5", "conteudo post de id 5"),
    new Post(6, "titulo post 6", "conteudo post de id 6"),
    new Post(7, "titulo post 7", "conteudo post de id 7"),
    new Post(8, "titulo post 8", "conteudo post de id 8"),
    new Post(9, "titulo post 9", "conteudo post de id 9"),
    new Post(10, "titulo post 10", "conteudo post de id 10")
   );
};

return $app;
?>
