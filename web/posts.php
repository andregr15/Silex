<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

require_once 'bootstrap.php';

$post = $app['controllers_factory'];

$post->get('/', function(Silex\Application $app) {
  $posts = $app['posts'];
  foreach($posts as $p)
  {
    echo "id: {$p['id']} Conteúdo: {$p['conteudo']} <a href=/posts/{$p['id']}>    Detalhe</a><br/>";
  }
  return new Response("", 200);
});

$post->get('/{id}', function(Silex\Application $app, $id) {
  $posts = $app['posts'];

  if(!isset($id))
  {
    $app->abort(500, "O id não pode ser nulo");
  }

  if(!isset($posts[$id]))
  {
    $app->abort(500, "Não existe um post com o id solicitado");
  }

  return new Response("id: " . $posts[$id]['id'] . " Conteúdo: " . $posts[$id]['conteudo'], 200);
})->assert('id', '\d+');

return $post;

?>
