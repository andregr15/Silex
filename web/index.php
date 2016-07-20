<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug']=true;

$posts = array(
  1 => array ( "id"=> 1, "conteudo"=> "conteudo post de id 1"),
  2 => array ( "id"=> 2, "conteudo"=> "conteudo post de id 2"),
  3 => array ( "id"=> 3, "conteudo"=> "conteudo post de id 3"),
  4 => array ( "id"=> 4, "conteudo"=> "conteudo post de id 4"),
  5 => array ( "id"=> 5, "conteudo"=> "conteudo post de id 5"),
  6 => array ( "id"=> 6, "conteudo"=> "conteudo post de id 6"),
  7 => array ( "id"=> 7, "conteudo"=> "conteudo post de id 7"),
  8 => array ( "id"=> 8, "conteudo"=> "conteudo post de id 8"),
  9 => array ( "id"=> 9, "conteudo"=> "conteudo post de id 9"),
  10 => array ( "id"=> 10, "conteudo"=> "conteudo post de id 10"),
);

$app->get('/posts/{id}', function(Silex\Application $app, $id) use($posts)
{
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

$app->run();

?>
