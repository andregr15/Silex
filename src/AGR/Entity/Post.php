<?php
namespace AGR\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="posts")
 * @ORM\Entity(repositoryClass="AGR\Entity\PostRepository")
 */
class Post{

  /**
  * @ORM\Id
  * @ORM\Column(type="integer")
  * @ORM\GeneratedValue
  */
  private $id;

  /** @ORM\Column(length=100) */
  private $titulo;

  /** @ORM\Column(type="text") */
  private $conteudo;

  public function __construct($id, $titulo, $conteudo){
    $this->id = $id;
    $this->titulo = $titulo;
    $this->conteudo = $conteudo;
  }

  public function getId(){
    return $this->id;
  }

  public function setId($id){
    $this->id = $id;
  }

  public function getTitulo(){
    return $this->titulo;
  }

  public function setTitulo($titulo){
    $this->titulo = $titulo;
  }

  public function getConteudo(){
    return $this->conteudo;
  }

  public function setConteudo($conteudo){
    $this->conteudo = $conteudo;
  }

}

?>
