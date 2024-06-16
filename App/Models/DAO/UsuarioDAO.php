<?php

namespace App\Models\DAO;

use App\Models\Entidades\Usuario;

class UsuarioDAO extends BaseDAO
{
    public function listar()
    {
        $resultado = $this->select('SELECT * FROM usuario');
        return $resultado->fetchAll(\PDO::FETCH_CLASS, Usuario::class);
    }

    public function salvar(Usuario $usuario)
{
    try {
        $nome = $usuario->getNome();
        $login = $usuario->getLogin();
        $senha = $usuario->getSenha();

        return $this->insert(
            'usuario',
            "nome, login, senha",
            [':nome' => $nome, ':login' => $login, ':senha' => $senha]
        );

    } catch (\Exception $e) {
        throw new \Exception("Erro na gravação de dados.", 500);
    }
}


    public function atualizar(Usuario $usuario)
    {
        try {
            $id = $usuario->getId();
            $nome = $usuario->getNome();
            $login = $usuario->getLogin();
            $senha = $usuario->getSenha();

            return $this->update(
                'usuario',
                "nome = :nome, login = :login, senha = :senha",
                [':id' => $id, ':nome' => $nome, ':login' => $login, ':senha' => $senha],
                "id = :id"
            );

        } catch (\Exception $e) {
            throw new \Exception("Erro na gravação de dados.", 500);
        }
    }

    public function excluir(Usuario $usuario)
    {
        try {
            $id = $usuario->getId();

            return $this->delete('usuario', "id = :id", [':id' => $id]);

        } catch (\Exception $e) {
            throw new \Exception("Erro ao deletar", 500);
        }
    }

    public function buscarPorLogin($login)
    {
        $resultado = $this->select("SELECT * FROM usuario WHERE login = :login", [':login' => $login]);
        return $resultado->fetchObject(Usuario::class);
    }

    public function buscarPorId($id)
    {
        try {
            $resultado = $this->select('SELECT * FROM usuario WHERE id = :id', [':id' => $id]);
            return $resultado->fetchObject(Usuario::class);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao buscar usuário por ID: " . $e->getMessage());
        }
    }
}
