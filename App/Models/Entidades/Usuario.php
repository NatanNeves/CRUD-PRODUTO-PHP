<?php

namespace App\Models\Entidades;

class Usuario{
    private $login;
    private $nome;
    private $senha;
    private $email;
    private $permissao;

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPermissao()
    {
        return $this->permissao;
    }

    public function setPermissao($permissao)
    {
        $this->permissao = $permissao;
    }

    public function setUsuario($dadosform)
    {
        $this->setLogin($dadosform['login']);
        $this->setNome($dadosform['nome']);
        $this->setSenha($dadosform['senha']);
        $this->setEmail($dadosform['email']);
        $this->setPermissao($dadosform['permissao']);
    }
}
