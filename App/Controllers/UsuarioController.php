<?php

namespace App\Controllers;

use App\Lib\Sessao;
use App\Lib\Util;
use App\Models\DAO\UsuarioDAO;
use App\Models\Entidades\Usuario;

class UsuarioController extends Controller
{
    public function listar()
    {
        $usuarioDAO = new UsuarioDAO();
        $usuarios = $usuarioDAO->listar();

        self::setViewParam('usuarios', $usuarios);
        $this->render('/usuario/listar');

        Sessao::limpaMensagem();
    }

    public function cadastrar()
    {
        $this->render('/usuario/cadastrar');
        Sessao::limpaMensagem();
        Sessao::limpaErro();
    }

    public function salvar()
    {
        $dadosForm = Util::sanitizar($_POST);

        $usuario = new Usuario();
        $usuario->setNome($dadosForm['nome']);
        $usuario->setLogin($dadosForm['login']);
        $usuario->setSenha($dadosForm['senha']);

        $usuarioDAO = new UsuarioDAO();
        $usuarioExistente = $usuarioDAO->buscarPorLogin($usuario->getLogin());

        if ($usuarioExistente) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Já existe um usuário com este login.</div>');
            $this->redirect('/usuario/cadastrar');
        }

        try {
            $usuarioDAO->salvar($usuario);
            Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso.</div>');
            $this->redirect('/usuario/listar');
        } catch (\Exception $e) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>');
            $this->redirect('/usuario/cadastrar');
        }
    }

    public function editar($params)
    {
        $id = $params[0]; // Supondo que o parâmetro seja o ID do usuário

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscarPorId($id);

        if (!$usuario) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Usuário não encontrado.</div>');
            $this->redirect('/usuario/listar');
        }

        self::setViewParam('usuario', $usuario);
        $this->render('/usuario/editar');

        Sessao::limpaMensagem();
    }

    public function atualizar()
    {
        $dadosForm = Util::sanitizar($_POST);

        // Busca o usuário existente para edição
        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscarPorId($dadosForm['id']);

        if (!$usuario) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Usuário não encontrado.</div>');
            $this->redirect('/usuario/listar');
        }

        // Atualiza os atributos do usuário com os novos valores do formulário
        $usuario->setNome($dadosForm['nome']);
        $usuario->setLogin($dadosForm['login']);

        // Verifica se a senha foi alterada no formulário
        if (!empty($dadosForm['senha'])) {
            $usuario->setSenha($dadosForm['senha']);
        }

        try {
            $usuarioDAO->atualizar($usuario);
            Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Usuário atualizado com sucesso.</div>');
            $this->redirect('/usuario/listar');
        } catch (\Exception $e) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>');
            $this->redirect('/usuario/editar/' . $usuario->getId()); // Redireciona usando o ID do usuário
        }
    }

    public function excluir($params)
    {
        $id = $params[0]; // Supondo que o parâmetro seja o ID do usuário

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscarPorId($id);

        if (!$usuario) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Usuário não encontrado.</div>');
        } else {
            try {
                $usuarioDAO->excluir($usuario);
                Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Usuário excluído com sucesso.</div>');
            } catch (\Exception $e) {
                Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>');
            }
        }

        $this->redirect('/usuario/listar');
    }

    public function login()
    {
        $this->render('/usuario/login');
        Sessao::limpaMensagem();
    }

    public function autenticar()
    {
        $dadosForm = Util::sanitizar($_POST);
        $login = $dadosForm['login'];
        $senha = $dadosForm['senha'];

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscarPorLogin($login);

        if (!$usuario || $usuario->getSenha() !== $senha) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Login ou senha inválidos.</div>');
            $this->redirect('/usuario/login');
        }

        $_SESSION['usuario'] = [
            'id' => $usuario->getId(),
            'nome' => $usuario->getNome(),
            'login' => $usuario->getLogin()
        ];

        $this->redirect('/usuario/listar');
    }

    public function logout()
    {
        unset($_SESSION['usuario']);
        $this->redirect('/usuario/login');
    }

    public static function verificaLogin()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /usuario/login');
            exit();
        }
    }
}

