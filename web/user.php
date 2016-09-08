<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

require_once 'bootstrap.php';

$user = $app['controllers_factory'];

$user->get('/cadastrarUsuario', function(Request $request) use ($app) {
  return $app['twig']->render('cadastroUsuario.twig.html', array('statusCadastro' => null));
})
  ->bind('cadastrarUsuario');


$user->post('/cadastrarUsuario', function(Request $request) use ($app, $em) {
    $nome = $request->request->get('_username');
    $senhaTexto = $request->request->get('_password');

    $repo = $em->getRepository('AGR\Entity\User');
    $user = $repo->loadUserByNome($nome);

    $msg = null;

    if($user && $user instanceof AGR\Entity\User && $user->getUsername() == $nome){
        $msg = "Já existe usuário cadastrado com o nome {$nome}!";
    } else {
        $user1 = new AGR\Entity\User();
        $user1->setUsername($nome);
        $user1->setSenhaTexto($senhaTexto);
        $user1->setRoles('ROLE_USER');
        $repo->insert($user1);
        $msg = "Usuário cadastrado com sucesso!";
    }

    return $app['twig']->render('cadastroUsuario.twig.html', array('statusCadastro' => $msg));
})
  ->bind('_cadastroUsuario');

return $user;

?>
