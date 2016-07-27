<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once 'bootstrap.php';

use Symfony\Component\HttpFoundation\Response;

$app->mount("/posts", include 'posts.php');

$app->run();

?>
