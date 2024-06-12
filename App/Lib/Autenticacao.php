<?php

namespace App\Lib;

use App\Models\DAO\UsuarioDAO;

class Autenticacao
{
    public static function autenticar($login, $senha)
    {
        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->autenticar($login, $senha);

        if ($usuario) {
            Sessao::gravaUsuario($usuario);
            return true;
        } else {
            return false;
        }
    }

    public static function verificarLogin()
    {
        if (!Sessao::usuarioLogado()) {
            header('Location: http://' . APP_HOST . '/login');
            exit;
        }
    }
}
