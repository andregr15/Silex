<?php

namespace AGR\Entity;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
  public function loadPostById($id){
    if(!$id){
      return "Id obrigatório!";
    }

    $post = $this->findOneById($id);

    return $post;
  }

  public function supportsClass($class){
    return $class === 'AGR\Entity\Post';
  }

  public function insert(Post $post){
    $this->getEntityManager()->persist($post);
    $this->getEntityManager()->flush();
    return $post;
  }

  public function update(Post $post){
    $this->getEntityManager()->merge($post);
    $this->getEntityManager()->flush($post);
    return $post;
  }

  public function delete(Post $post){
    $this->getEntityManager()->remove($post);
    $this->getEntityManager()->flush($post);
    return $post;
  }

  public function clearBd($connection){
    $platform = $connection->getDatabasePlatform();
    $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
    $connection->executeUpdate($platform->getTruncateTableSQL("posts","true"));
    $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');
  }
}

?>
