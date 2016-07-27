<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug']=true;

$app['posts'] = function() {
  return array(
    1 => array ( "id"=> 1, "conteudo"=> "conteudo post de id 1"),
    2 => array ( "id"=> 2, "conteudo"=> "conteudo post de id 2"),
    3 => array ( "id"=> 3, "conteudo"=> "conteudo post de id 3"),
    4 => array ( "id"=> 4, "conteudo"=> "conteudo post de id 4"),
    5 => array ( "id"=> 5, "conteudo"=> "conteudo post de id 5"),
    6 => array ( "id"=> 6, "conteudo"=> "conteudo post de id 6"),
    7 => array ( "id"=> 7, "conteudo"=> "conteudo post de id 7"),
    8 => array ( "id"=> 8, "conteudo"=> "conteudo post de id 8"),
    9 => array ( "id"=> 9, "conteudo"=> "conteudo post de id 9"),
    10 => array ( "id"=> 10, "conteudo"=> "conteudo post de id 10")
   );
};

return $app;
?>
