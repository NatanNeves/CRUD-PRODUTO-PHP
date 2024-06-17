<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Excluir Usuário</h1>
        
        <?php echo \App\Lib\Sessao::retornaMensagem(); ?>
        
        <?php if ($viewVar['usuario']): ?>
            <div class="card">
                <div class="card-body">
                    <p>Você tem certeza que deseja excluir o usuário <strong><?php echo htmlspecialchars($viewVar['usuario']->getLogin()) . ' - ' . htmlspecialchars($viewVar['usuario']->getNome()); ?></strong>?</p>
                    <form action="<?php echo 'http://' . APP_HOST . '/usuario/excluir'; ?>" method="post">
                        <input type="hidden" name="login" value="<?php echo htmlspecialchars($viewVar['usuario']->getLogin()); ?>">
                        <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
                        <a href="<?php echo 'http://' . APP_HOST . '/usuario/listar'; ?>" class="btn btn-info">Cancelar</a>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <p>Usuário não encontrado.</p>
        <?php endif; ?>
        
    </div>
</main>
