<main role="main" class="flex-shrink-0">
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <h1 class="mt-2">Cadastro de Usuário</h1>
        <?php
          // Mensagens de Erro ou Sucesso na execução das funções
          echo $Sessao::retornaMensagem();
          $Sessao::limpaMensagem();
        ?>
        <form action="<?php echo 'http://' . APP_HOST . '/usuario/salvar/novo'; ?>" method="post" id="formCadastro">
          <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" name="nome" value="<?php echo $Sessao::retornaValorFormulario('nome'); ?>" required>
          </div>
          <div class="form-group">
            <label for="login">Login</label>
            <input type="text" class="form-control" name="login" value="<?php echo $Sessao::retornaValorFormulario('login'); ?>" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $Sessao::retornaValorFormulario('email'); ?>" required>
          </div>
          <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" class="form-control <?php if ($Sessao::retornaErro('errosenha') != "") echo "is-invalid"; ?>" name="senha" required>
            <div class="invalid-feedback"> 
                <?php echo $Sessao::retornaErro('errosenha'); $Sessao::limpaErro(); ?>
            </div>
          </div>
          <button type="submit" class="btn btn-success btn-sm">Salvar</button>
        </form>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
</main>
