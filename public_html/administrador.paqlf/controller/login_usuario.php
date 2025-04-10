<?php
 
class Usuario {
    private $id = null;
    private $nome = null;
    private $email = null;
    private $laboratorio = null;
    //private $laboratorioAtivo = null;
 	private $resultado = null;
    private $alteracao_laboratorio = null;
    private $usuario = null;
    private $selo = null;
    private $login = null;
	
	
    public function getId() {
        return $this->id;
    }
 
    public function getNome() {
        return $this->nome;
    }
 
    public function getEmail() {
        return $this->email;
    }
 
    public function getLaboratorio() {
        return $this->laboratorio;
    }
	
    /* public function getLaboratorioAtivo() {
        return $this->laboratorioAtivo;
    }*/
	
    public function getResultado() {
        return $this->resultado;
    }
 
    public function getAlteracaoLaboratorio() {
        return $this->alteracao_laboratorio;
    }
 
    public function getUsuario() {
        return $this->usuario;
    }

    public function getSelo() {
        return $this->selo;
    }

    public function getLogin() {
        return $this->login;
    }
 

    public function setId($id) {
        $this->id = $id;
    }
 
    public function setNome($nome) {
        $this->nome = $nome;
    }
 
    public function setEmail($email) {
        $this->email = $email;
    }
 
    public function setLaboratorio($laboratorio) {
        $this->laboratorio = $laboratorio;
    }
	
     /*public function setLaboratorioAtivo($laboratorioAtivo) {
        $this->laboratorioAtivo = $laboratorioAtivo;
    }*/

	public function setResultado($resultado) {
        $this->resultado = $resultado;
    }
 
    public function setAlteracaoLaboratorio($alteracao_laboratorio) {
        $this->alteracao_laboratorio = $alteracao_laboratorio;
    }
 
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setSelo($selo) {
        $this->selo = $selo;
    }

    public function setLogin($login) {
        $this->login = $login;
    }
}



?>