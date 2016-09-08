<?php

namespace AGR\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AGR\Entity\UserRepository")
 */
class User implements UserInterface
{
   /**
   * @ORM\Id
   * @ORM\Column(type="integer", name="user_codigo")
   * @ORM\GeneratedValue
   */
    private $codigo;

    /** @ORM\Column(type="text", name="user_nome") */
    private $username;

    /** @ORM\Column(type="text", name="user_senha") */
    private $senha;

    private $senhaTexto;

    /** @ORM\Column(type="datetime", name="criado_em", options={"default" : "CURRENT_TIMESTAMP"}) */
    private $criadoEm;

    /** @ORM\Column(type="text", name="user_roles") */
    private $roles;

    public function __construct(){
      $this->roles = array ('ROLE_USER');
      $this->criadoEm = new \Datetime();
    }

    public function getCodigo(){
      return $this->codigo;
    }

    public function setCodigo($codigo){
      $this->codigo = $codigo;
    }

    public function getUsername(){
      return $this->username;
    }

    public function setUsername($username){
      $this->username = $username;
    }

    public function getPassword(){
      return $this->senha;
    }

    public function setPassword($senha){
      $this->senha = $senha;
    }

    public function getSenhaTexto(){
      return $this->senhaTexto;
    }

    public function setSenhaTexto($senhaTexto){
      $this->senhaTexto = $senhaTexto;
    }

    public function getCriadoEm(){
      return $this->criadoEm;
    }

    public function setCriadoEm($criadoEm){
      $this->criadoEm = \DateTime::createFromFormat('d/m/Y H:i:s', $criadoEm);
    }

    public function getRoles(){
      return $this->roles;
    }

    public function setRoles($roles){
      $this->roles = $roles;
    }

    public function getSalt(){
      return null;
    }

    public function eraseCredentials(){
      $this->senhaTexto = null;
    }

    public function __toString(){
      return $this->getUsername();
    }

    public function toArray(){
      return array(
        "codigo"   => $this->getCodigo(),
        "nome"     => $this->getUsername(),
        "salt"     => $this->getSalt(),
        "roles"    => $this->getRoles(),
        "senha"    => $this->getPassword(),
        "criadoEm" => $this->getCriadoEm()
      );
    }
}


?>
