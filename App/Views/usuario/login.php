<main role="main" class="flex-shrink-0">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h1 class="mt-5">Login</h1>
                <form action="<?php echo 'http://' . APP_HOST . '/usuario/autenticar'; ?>" method="post">
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" class="form-control" id="login" name="login" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
                <br>
                <?php
                // Mensagens de Erro ou Sucesso na execução das funções
                echo $Sessao::retornaMensagem();
                $Sessao::limpaMensagem();
                ?>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</main>
