<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Excluir Usuário</h1>
        
        <?php
        // Mensagens de Erro ou Sucesso na execução das funções
        echo $Sessao::retornaMensagem();
        $Sessao::limpaMensagem();

        if ($viewVar['usuario']) {
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<p>Você tem certeza que deseja excluir o usuário <strong>' . $viewVar['usuario']->getLogin() . ' - ' . $viewVar['usuario']->getNome() . '</strong>?</p>';
            echo '<form action="http://' . APP_HOST . '/usuarios/excluir" method="post">';
            echo '<input type="hidden" name="login" value="' . $viewVar['usuario']->getLogin() . '">';
            echo '<button type="submit" class="btn btn-danger">Confirmar Exclusão</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        } else {
            echo "Usuário não encontrado.";
        }
        ?>
        
    </div>
</main>
