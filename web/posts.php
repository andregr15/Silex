<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

require_once 'bootstrap.php';

$posts = $app['controllers_factory'];

$posts->get('/fixture', function(Silex\Application $app) use($em) {
  $posts = $app['posts'];

  try{
    $postRepository = $em->getRepository('AGR\Entity\Post');
    $postRepository->clearBd($em->getConnection());
    foreach($posts as $post)
    {
      $postRepository->insert($post);
    }
  }
  catch(Exception $e) {
    $app->abort(500, 'Erro fixture: '.  $e->getMessage(). "\n");
  }

  return new Response("Fixture executada", 200);
})
  ->bind("_posts");


$posts->get('/', function(Silex\Application $app) use($em) {
  try{
    $postRepository = $em->getRepository('AGR\Entity\Post');
    $posts = $postRepository->findAll();
  }
  catch(Exception $e) {
    $app->abort(500, 'Erro exibir todos os posts: '.  $e->getMessage(). "\n");
  }
  return $app['twig']->render('posts.twig', array("posts" => $posts));
})
  ->bind("posts");

return $posts;

?>
