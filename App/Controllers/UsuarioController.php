<?php


namespace App\Controllers;

use App\Lib\Sessao;
use App\Lib\Util; // Importe a classe Util aqui

use App\Models\DAO\UsuarioDAO;
use App\Models\Entidades\Usuario;

class UsuarioController extends Controller
{
    
    public function excluirConfirma($params)
    {
        $login = urldecode($params[0]);

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscarPorLogin($login);

        if (!$usuario) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Usuário não encontrado.</div>');
        }

        $this->setViewParam('usuario', $usuario);
        $this->render('/usuario/excluirConfirma');

        Sessao::limpaMensagem();
    }
    
    public function listar()
    {
        try {
            $usuarioDAO = new UsuarioDAO();
            $usuarios = $usuarioDAO->listar();

            $this->setViewParam('usuarios', $usuarios);
            $this->render('/usuario/listar');
        } catch (\Exception $e) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Erro ao listar usuários: ' . $e->getMessage() . '</div>');
            $this->render('/erro/index');
        }

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
    $login = $params[0]; // Supondo que o parâmetro seja o login do usuário

    $usuarioDAO = new UsuarioDAO();
    $usuario = $usuarioDAO->buscarPorLogin($login);

    if (!$usuario) {
        Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Usuário não encontrado.</div>');
        $this->redirect('/usuario/listar');
    }

    $this->setViewParam('usuario', $usuario);
    $this->render('/usuario/editar');

    Sessao::limpaMensagem();
}

    public function atualizar()
{
    $dadosForm = Util::sanitizar($_POST);

    // Busca o usuário existente para edição
    $usuarioDAO = new UsuarioDAO();
    $usuario = $usuarioDAO->buscarPorLogin($dadosForm['login']);

    if (!$usuario) {
        Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Usuário não encontrado.</div>');
        $this->redirect('/usuario/listar');
    }

    // Atualiza os atributos do usuário com os novos valores do formulário
    $usuario->setNome($dadosForm['nome']);

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
        $this->redirect('/usuario/editar/' . $usuario->getLogin()); // Redireciona usando o login do usuário
    }
}

   public function excluir()
    {
        $dadosForm = Util::sanitizar($_POST);

        // Recupera o login do usuário a ser excluído
        $login = $dadosForm['login'];

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscarPorLogin($login);

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

