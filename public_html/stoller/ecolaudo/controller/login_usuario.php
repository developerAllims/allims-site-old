<?php
 
class Usuario {
    private $id = null;
    private $nome = null;
    private $email = null;
    private $senha = null;
 	private $telefone = null;
    private $cidade = null;
    private $estado = null;
    private $insert = null;
    private $is_enabled = null;
	
	
    public function getId() {
        return $this->id;
    }
 
    public function getNome() {
        return $this->nome;
    }
 
    public function getEmail() {
        return $this->email;
    }
 
    public function getSenha() {
        return $this->senha;
    }
	
	public function getTelefone() {
        return $this->telefone;
    }
 
    public function getCidade() {
        return $this->cidade;
    }
 
    public function getEstado() {
        return $this->estado;
    }

    public function getIs_Enabled() {
        return $this->is_enabled;
    }
 
    public function getCan_Insert_Rec() {
        return $this->insert;
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
 
    public function setSenha($senha) {
        $this->senha = $senha;
    }
	
	public function setTelefone($nome) {
        $this->telefone = $nome;
    }
 
    public function setCidade($email) {
        $this->cidade = $email;
    }
    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setCan_Insert_Rec($insert) {
        $this->insert = $insert;
    }

    public function setIs_Enabled($is_enabled) {
        $this->is_enabled = $is_enabled;
    }
}



?>