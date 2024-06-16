<main role="main" class="flex-shrink-0">
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <h1 class="mt-2">Cadastro de Usuário</h1>
        <?php
          // Mensagens de Erro ou Sucesso na execução das funções
          echo \App\Lib\Sessao::retornaMensagem();
          \App\Lib\Sessao::limpaMensagem();
        ?>
        <form action="<?php echo 'http://'.APP_HOST.'/usuario/salvar/novo'; ?>" method="post" id="formCadastro">
          <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" name="nome" value="<?php if (isset($viewVar['usuario'])) echo $viewVar['usuario']->getNome(); ?>" required>
          </div>
          <div class="form-group">
            <label for="login">Login</label>
            <input type="text" class="form-control <?php if (\App\Lib\Sessao::retornaErro('errologin') != "") echo "is-invalid"; ?>" name="login" value="<?php if (isset($viewVar['usuario'])) echo $viewVar['usuario']->getLogin(); ?>" required>
            <div class="invalid-feedback">
              <?php echo \App\Lib\Sessao::retornaErro('errologin'); \App\Lib\Sessao::limpaErro(); ?>
            </div>
          </div>
          <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" class="form-control <?php if (\App\Lib\Sessao::retornaErro('errosenha') != "") echo "is-invalid"; ?>" name="senha" required>
            <div class="invalid-feedback">
              <?php echo \App\Lib\Sessao::retornaErro('errosenha'); \App\Lib\Sessao::limpaErro(); ?>
            </div>
          </div>
          <div class="form-group">
            <label for="confirmarSenha">Confirmar Senha</label>
            <input type="password" class="form-control <?php if (\App\Lib\Sessao::retornaErro('erroconfirmarsenha') != "") echo "is-invalid"; ?>" name="confirmarSenha" required>
            <div class="invalid-feedback">
              <?php echo \App\Lib\Sessao::retornaErro('erroconfirmarsenha'); \App\Lib\Sessao::limpaErro(); ?>
            </div>
          </div>
          <button type="submit" class="btn btn-success btn-sm">Salvar</button>
        </form>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
</main>
