<main role="main" class="flex-shrink-0">
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <h1 class="mt-2">Exclusão de Usuário</h1>
        <form action="http://<?php echo APP_HOST; ?>/usuario/excluir" method="post" id="formExcluirUsuario">
          <input type="hidden" name="login" value="<?php echo htmlspecialchars($viewVar['usuario']->getLogin()); ?>">
          <div class="card text-white bg-danger mb-3" style="max-width: 22rem;">
            <div class="card-header">Confirmação da Exclusão do Usuário</div>
            <div class="card-body">
              <h5 class="card-title">Excluir?</h5>
              Confirma exclusão do usuário: <?php echo htmlspecialchars($viewVar['usuario']->getNome()); ?> ?
              <button type="submit" class="btn btn-primary btn-sm mt-2">Confirmar</button>
              <a href="http://<?php echo APP_HOST; ?>/usuario/listar" class="btn btn-info btn-sm mt-2">Cancelar</a>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
</main>
