<?php

include_once("model/funcionario.php");

class Controller {
 public $model; //declaração de variável
 public function __construct()//chamado automaticamente quando chama a classe  
    {  
        $this->model = new Model();//inicia a classe Model que iremos criar
    } 
 public function invoke() //essa função irá controlar o que será exibido de acordo com a solicitação do usuário
 {
  if (!isset($_GET['funcionario'])) //verifica se está sendo passado algum funcionário 
  {
   $funcionarios = $this->model->getFuncList(); //Se não está passando, vamos retornar uma função que terá toda lista de funcionários
   include 'view/funcList.php'; //neste caso exibe a página funclist.php com  a lista
  }
  else //caso exista um get com o nome do funcionario
  {
   $funcionarios = $this->model->getFunc($_GET['funcionario']); //chama a função getFunc que retornará um usuário cujo nome seja igual ao valor do get
   include 'view/viewFunc.php'; //neste caso, exibe a página viewFunc.php
  }
 }
}
 
?>