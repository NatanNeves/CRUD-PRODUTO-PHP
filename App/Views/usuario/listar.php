<main role="main" class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Listagem de Usuários</h1>

    <?php
    // Mensagens de Erro ou Sucesso na execução das funções
    echo $Sessao::retornaMensagem();
    $Sessao::limpaMensagem();

    if (count($viewVar['usuarios']) > 0) {
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
      foreach ($viewVar['usuarios'] as $usuario) {
        $login = $usuario->getLogin();
        $nome = $usuario->getNome();
        $email = $usuario->getEmail(); // Aqui chama o método getEmail() definido na classe Usuario
        $permissao = $usuario->getPermissao(); // Aqui chama o método getPermissao() definido na classe Usuario

        echo '<tr>';
        echo '<td>' . $login . '</td>';
        echo '<td>' . $nome . '</td>';
        echo '<td>' . $email . '</td>';
        echo '<td>' . $permissao . '</td>';
        echo '<td> <a href="http://' . APP_HOST . '/usuario/editar/' . $login . '" class="btn btn-info btn-sm">Editar</a>';

        // Verifica se $nome está definido antes de passá-lo para urlencode()
        if (isset($nome)) {
          echo '<a href="http://' . APP_HOST . '/usuario/excluirConfirma/' . $login . '/' . urlencode($nome) . '" class="btn btn-danger btn-sm mt-1">Excluir</a>';
        } else {
          echo '<a href="http://' . APP_HOST . '/usuario/excluirConfirma/' . $login . '" class="btn btn-danger btn-sm mt-1">Excluir</a>';
        }

        echo '</td>';
        echo '</tr>';
      }
      echo '</tbody>';
      echo '</table>';
      echo '</div>';
    } else {
      echo "Nenhum Usuário Encontrado.";
    }
    ?>

  </div>
</main>
