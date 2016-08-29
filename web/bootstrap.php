<?php
require_once __DIR__.'/../vendor/autoload.php';

use AGR\Entity\Post;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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


$app['user_repository'] = function($app) use ($em){
  $user = new AGR\Entity\User();
  $repo = $em->getRepository('AGR\Entity\User');
  $repo->setPasswordEncoder($app['security.encoder_factory']->getEncoder($user));
  return $repo;
};


$app->register(new Silex\Provider\SessionServiceProvider());


$app->register(new SecurityServiceProvider(), array(
  'security.firewalls' => array(
    'admin' => array(
      'anonymous' => true,
      'pattern'   => '^/',
      'form'      => array('login_path' => '/', 'check_path' => '/admin/login_check', 'default_target_path' => '/posts'
      ),
      'users'     => function () use($app){
        return $app['user_repository'];
        },
      'logout'    => array('logout_path' => '/admin/logout', 'invalidate_session' => true),
    )
  )
));

$app->get('/', function(Request $request) use ($app) {
  return $app['twig']->render('index.twig.html', array(
    'error'         => $app['security.last_error']($request) == 'Bad credentials.' ? 'Usuário não cadastrado.' : $app['security.last_error']($request),
    'last_username' => $app['session']->get('_security.last_username')
  ));
})
  ->bind('login');


  $app['security.access_rules'] = array (
  array('^/posts', 'ROLE_USER'),
  array('^/post', 'ROLE_USER')
);

$app['security.role_hierarchy'] = array(
    'ROLE_ADMIN' => array('ROLE_USER')
);

return $app;
?>
