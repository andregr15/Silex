<?php

namespace AGR\Entity;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserProviderInterface
{

  private $passwordEncoder;

  public function setPasswordEncoder(PasswordEncoderInterface $passwordEncoder){
    $this->passwordEncoder = $passwordEncoder;
  }

  public function loadUserByUsername($username){
    $user = $this->loadUserByNome($username);
    if(!$user){
      throw new UsernameNotFoundException("Usuário %s não existe!".$username);
    }

    return $this->arrayToObject($user->toArray());
  }

  public function loadUserByNome($username){
    return $this->findOneByUsername($username);
  }

  public function refreshUser(UserInterface $user){
    if(!$user instanceof User){
      throw new UnsupportedUserException("Instance of %s are not supported!".get_class($user));
    }
    return $user;
  }

  public function supportsClass($class){
    return $class === 'TecnoSystem\Entitys\Usuario';
  }

  public function encodePassword(User $user){
    if($user->getSenhaTexto()){
      $user->setPassword($this->passwordEncoder->encodePassword($user->getSenhaTexto(), $user->getSalt()));
      $user->setSenhaTexto(null);
    }
  }

  public function createAdminUser($username, $password){
    $user = new User();
    $user->setUsername($username);
    $user->setSenhaTexto($password);
    $user->setRoles("ROLE_ADMIN");
    return $this->insert($user);
  }

  public function insert(User $user){
    $this->encodePassword($user);
    $this->getEntityManager()->persist($user);
    $this->getEntityManager()->flush();
    return $user;
  }

  public function update(User $user){
    $this->encodePassword($user);
    $this->getEntityManager()->merge($user);
    $this->getEntityManager()->flush();
    return $user;
  }

  public function objectToArray($user){
    return array(
      "codigo" => $this->getCodigo(),
      "nome"   => $this->getUsername(),
      "criadoEm"   => $this->getCriadoEm()->format(self::DATE_FORMAT),
      "roles"  => implode(',', $this->getRoles()),
      "senha"  => $this->getPassword()
    );
  }

  public function arrayToObject($userArr, $user = null){
    if(!isset($user)){
      $user = new User();

      $user->setCodigo(isset($userArr['codigo']) ? $userArr['codigo'] : null);
    }

    $username = isset($userArr['nome']) ? $userArr['nome'] : null;
    $password = isset($userArr['senha']) ? $userArr['senha'] : null;
    $roles = isset($userArr['roles']) ? explode(',', $userArr['roles']) : array();
    $createdAt = isset($userArr['criadoEm']) ? date_format($userArr['criadoEm'], "d/m/Y H:i:s") : null;

    if($username){
      $user->setUsername($username);
    }

    if($password){
      $user->setPassword($password);
    }

    if($roles){
      $user->setRoles($roles);
    }

    if($createdAt){
      $user->setCriadoEm($createdAt);
    }

    return $user;
  }
}

?>
