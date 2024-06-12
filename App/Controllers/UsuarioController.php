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

        self::setViewParam('listaUsuarios', $usuarioDAO->listar());

        $this->render('/usuarios/listar');

        Sessao::limpaMensagem();
    }
    
    public function editar($params)
    {
        $login = $params[0];

        $usuarioDAO = new UsuarioDAO();

        $usuario = $usuarioDAO->listar($login);

        if ($usuario == null) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Falha ao recuperar dados do usuário login=' . $login . '</div>');
            $this->redirect('/usuarios/listar');
        }

        self::setViewParam('usuario', $usuario);

        $this->render('/usuarios/editar');

        Sessao::limpaMensagem();
    }
    
    public function salvar($param)
    {
        $cmd = $param[0];
        $dadosform = Util::sanitizar($_POST);

        $usuario = new Usuario();
        $usuario->setUsuario($dadosform);
        
        $errovalidacao = false;

        if (empty($dadosform['senha'])) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Verifique os Campos em Vermelho.</div>');
            Sessao::gravaErro('errosenha', 'Este campo deve ser preenchido');
            $errovalidacao = true;
        }

        if ($errovalidacao) {
            self::setViewParam('usuario', $usuario);
            if ($cmd == 'editar') {
                $this->render('/usuarios/editar');
            } elseif ($cmd == 'novo') {
                $this->render('/usuarios/cadastrar');
            }
            return;
        }

        $usuarioDAO = new UsuarioDAO();

        if ($cmd == 'editar') {
            $usuarioDAO->atualizar($usuario);
            Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Usuário atualizado com sucesso.</div>');
        } elseif ($cmd == 'novo') {
            $usuarioDAO->salvar($usuario);
            Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Novo usuário gravado com sucesso.</div>');
        }

        Sessao::limpaErro();
        $this->redirect('/usuarios/listar');
    }
    
    public function excluirConfirma($param)
    {
        $login = urldecode($param[0]);
        $nome = urldecode($param[1]);

        $usuario = new Usuario();
        $usuario->setLogin($login);
        $usuario->setNome($nome);

        self::setViewParam('usuario', $usuario);
        $this->render('/usuarios/excluirConfirma');
    }
    
    public function excluir()
    {
        $usuario = new Usuario();
        $usuario->setLogin(Util::sanitizar($_POST['login']));
        
        $usuarioDAO = new UsuarioDAO();

        if (!$usuarioDAO->excluir($usuario)) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Erro ao excluir usuário.</div>');
        } else {
            Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Usuário excluído com sucesso!</div>');
        }
        $this->redirect('/usuarios/listar');
    }

    public function cadastrar()
    {
        $this->render('/usuarios/cadastrar');
        Sessao::limpaMensagem();
        Sessao::limpaErro();
    }

    public function login()
    {
        $this->render('/login');
        Sessao::limpaMensagem();
    }

    public function authenticate()
    {
        $dadosform = Util::sanitizar($_POST);
        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->autenticar($dadosform['login'], $dadosform['senha']);

        if ($usuario) {
            Sessao::gravaUsuario($usuario);
            $this->redirect('/');
        } else {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Login ou senha inválidos.</div>');
            $this->redirect('/login');
        }
    }

    public function logout()
    {
        Sessao::limpaUsuario();
        $this->redirect('/login');
    }

    public function verificarLogin()
    {
        if (!Sessao::usuarioLogado()) {
            header('Location: http://' . APP_HOST . '/login');
            exit;
        }
    }
}
