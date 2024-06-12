<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Lista de Usuários</h1>
        
        <?php
        // Mensagens de Erro ou Sucesso na execução das funções
        echo $Sessao::retornaMensagem();
        $Sessao::limpaMensagem();

        if (count($viewVar['listaUsuarios']) > 0) {
            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered table-hover table-sm">';
            echo '<thead>';
            echo '<tr style="background-color: #bee5eb;">';
            echo '<th class="info">Login</th>';
            echo '<th class="info">Nome</th>';
            echo '<th class="info">Email</th>';
            echo '<th class="info">Permissão</th>';
            echo '<th class="info">Ações</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($viewVar['listaUsuarios'] as $usuario) {
                echo '<tr>';
                echo '<td>' . $usuario->getLogin() . '</td>';
                echo '<td>' . $usuario->getNome() . '</td>';
                echo '<td>' . $usuario->getEmail() . '</td>';
                echo '<td>' . $usuario->getPermissao() . '</td>';
                echo '<td>';
                echo '<a href="http://' . APP_HOST . '/usuarios/editar/' . $usuario->getLogin() . '" class="btn btn-info btn-sm">Editar</a>';
                echo '<a href="http://' . APP_HOST . '/usuarios/excluirConfirma/' . $usuario->getLogin() . '/' . urlencode($usuario->getNome()) . '" class="btn btn-danger btn-sm mt-1">Excluir</a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo "Nenhum usuário encontrado.";
        }
        ?>
        
    </div>
</main>

