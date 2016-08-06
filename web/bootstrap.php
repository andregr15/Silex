<?php
require_once __DIR__.'/../vendor/autoload.php';
use AGR\Entity\Post;

$app = new Silex\Application();
$app['debug']=true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__.'/../views'
));

$app['posts'] = function() {
  return array(
    new Post(1, "conteudo post de id 1"),
    new Post(2, "conteudo post de id 2"),
    new Post(3, "conteudo post de id 3"),
    new Post(4, "conteudo post de id 4"),
    new Post(5, "conteudo post de id 5"),
    new Post(6, "conteudo post de id 6"),
    new Post(7, "conteudo post de id 7"),
    new Post(8, "conteudo post de id 8"),
    new Post(9, "conteudo post de id 9"),
    new Post(10, "conteudo post de id 10")
   );
};

return $app;
?>
