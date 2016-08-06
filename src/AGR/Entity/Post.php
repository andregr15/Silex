<?php
namespace AGR\Entity;

class Post{

  private $id;
  private $conteudo;

  public function __construct($id, $conteudo){
    $this->id = $id;
    $this->conteudo = $conteudo;
  }

  public function getId(){
    return $this->id;
  }

  public function setId($id){
    $this->id = $id;
  }

  public function getConteudo(){
    return $this->conteudo;
  }

  public function setConteudo($conteudo){
    $this->conteudo = $conteudo;
  }

}

?>
