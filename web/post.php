<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

require_once 'bootstrap.php';

$post = $app['controllers_factory'];

$post->get('/{id}', function(Silex\Application $app, $id) use($em){
  if(!isset($id))
  {
    $app->abort(500, "O id não pode ser nulo");
  }

  $postRepository = $em->getRepository('AGR\Entity\Post');
  $post = $postRepository->loadPostById($id);

  if(!isset($post))
  {
    $app->abort(500, "Não existe um post com o id solicitado");
  }

  return $app['twig']->render('post.twig', array("post" => $post));
})
  ->assert('id', '\d+')
  ->bind('_post');

$post->get('/novo', function(Silex\Application $app) {
  return $app['twig']->render('novo_post.twig', array());
})
  ->bind("novo");

$post->post('/new', function(Request $request, Silex\Application $app) use($em) {
  try{
    $titulo = $request->request->get('titulo');
    $conteudo = $request->request->get('conteudo');

    $post = new AGR\Entity\Post(null, $titulo, $conteudo);

    $postRepository = $em->getRepository('AGR\Entity\Post');
    $post = $postRepository->insert($post);
  }
  catch(Exception $e) {
    $app->abort(500, 'Erro ao incluir um post: '.  $e->getMessage(). "\n");
  }

  return $app['twig']->render('post_incluido.twig', array("id" => $post->getId()));
})
  ->bind('incluir');


$post->get('/editar/{id}', function(Silex\Application $app, $id) use($em) {
  try{
    $postRepository = $em->getRepository('AGR\Entity\Post');
    $post = $postRepository->loadPostById($id);
  }
  catch(Exception $e) {
    $app->abort(500, 'Erro ao editar um post: '.  $e->getMessage(). "\n");
  }

  return $app['twig']->render('editar_post.twig', array('post' => $post));
})
  ->bind("editar");

$post->post('/update/{id}', function(Request $request, Silex\Application $app) use($em) {
  try{
    $id = $request->request->get('id');
    $titulo = $request->request->get('titulo');
    $conteudo = $request->request->get('conteudo');

    $postRepository = $em->getRepository('AGR\Entity\Post');

    $post = $postRepository->loadPostById($id);
    $post->setTitulo($titulo);
    $post->setConteudo($conteudo);

    $post = $postRepository->update($post);
  }
  catch(Exception $e) {
    $app->abort(500, 'Erro ao atualizar um post: '.  $e->getMessage(). "\n");
  }

  return $app['twig']->render('post_atualizado.twig', array("id" => $post->getId()));
})
->bind("atualizar");

$post->get('/excluir/{id}', function(Silex\Application $app, $id) use($em) {
  try{
    $postRepository = $em->getRepository('AGR\Entity\Post');
    $post = $postRepository->loadPostById($id);
    $postRepository->delete($post);
  }
  catch(Exception $e) {
    $app->abort(500, 'Erro ao excluir um post: '.  $e->getMessage(). "\n");
  }

  return $app['twig']->render('post_excluido.twig', array());
})
  ->bind("excluir");

return $post;

?>
