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

            $cols = ['nome' => $nome, 'login' => $login, 'senha' => $senha];
            $values = [':nome' => $nome, ':login' => $login, ':senha' => $senha];

            $this->insert('usuario', $cols, $values);
        } catch (\Exception $e) {
            throw new \Exception("Erro na gravação de dados: " . $e->getMessage(), 500);
        }
    }

    public function atualizar(Usuario $usuario)
{
    try {
        $login = $usuario->getLogin();
        $nome = $usuario->getNome();
        $senha = $usuario->getSenha();

        // Define os dados a serem atualizados
        $cols = ['nome' => ':nome', 'senha' => ':senha'];
        $values = [':nome' => $nome, ':senha' => $senha, ':login' => $login];

        // Realiza a atualização na tabela 'usuario'
        return $this->update(
            'usuario',
            $cols, // Colunas a serem atualizadas
            $values, // Valores correspondentes
            "login = :login" // Condição WHERE
        );
    } catch (\Exception $e) {
        throw new \Exception("Erro na atualização de dados: " . $e->getMessage(), 500);
    }
}

    public function excluir(Usuario $usuario)
    {
        try {
            $login = $usuario->getLogin();
            return $this->delete('usuario', "login = :login", [':login' => $login]);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao deletar usuário: " . $e->getMessage(), 500);
        }
    }



    public function buscarPorLogin($login)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE login = :login";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':login', $login);
            $stmt->execute();

            return $stmt->fetchObject(Usuario::class);
        } catch (\PDOException $e) {
            throw new \Exception("Erro ao buscar usuário por login: " . $e->getMessage(), 500);
        }
    }
}
