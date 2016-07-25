<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug']=true;

$app->mount("/posts", include 'posts.php');

$app->run();

?>
