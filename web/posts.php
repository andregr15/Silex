<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

require_once 'bootstrap.php';

$post = $app['controllers_factory'];

$post->get('/', function(Silex\Application $app) {
  $posts = $app['posts'];
  return $app['twig']->render('posts.twig', array("posts" => $posts));
  /*
  foreach($posts as $p)
  {
    echo "id: {$p->getId()} Conteúdo: {$p->getConteudo()} <a href=/posts/{$p->getId()}>    Detalhe</a><br/>";
  }
  return new Response("", 200);
  */
})
  ->bind("posts");

$post->get('/{id}', function(Silex\Application $app, $id) {
  $posts = $app['posts'];

  if(!isset($id))
  {
    $app->abort(500, "O id não pode ser nulo");
  }

  if(!isset($posts[$id -1]))
  {
    $app->abort(500, "Não existe um post com o id solicitado");
  }

  return $app['twig']->render('post.twig', array("post" => $posts[$id - 1]));
})
  ->assert('id', '\d+')
  ->bind('_post');

return $post;

?>
