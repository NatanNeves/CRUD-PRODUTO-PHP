<main role="main" class="flex-shrink-0">
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <h1 class="mt-2">Editar Usuário</h1>
        
        <?php
        // Mensagens de Erro ou Sucesso na execução das funções
        echo \App\Lib\Sessao::retornaMensagem();
        \App\Lib\Sessao::limpaMensagem();
        ?>
        
        <form action="<?php echo 'http://'.APP_HOST.'/usuario/atualizar'; ?>" method="post" id="formEditarUsuario">
          <div class="form-group">
            <input type="hidden" name="id" value="<?php echo $viewVar['usuario']->getId(); ?>">
          </div>
          <div class="form-group">
            <label for="nome">Nome do Usuário</label>
            <input type="text" class="form-control" name="nome" value="<?php echo $viewVar['usuario']->getNome(); ?>" required>
          </div>
          <div class="form-group">
            <label for="login">Login</label>
            <input type="text" class="form-control" name="login" value="<?php echo $viewVar['usuario']->getLogin(); ?>" required>
          </div>
          <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" class="form-control" name="senha" value="">
            <small class="form-text text-muted">Deixe em branco para manter a senha atual.</small>
          </div>
          <button type="submit" class="btn btn-success btn-sm">Salvar</button>
        </form>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
</main>
