<!-- views/usuarios/login.php -->

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php
    // Exibir mensagens de erro ou sucesso, se houver
    echo $Sessao::retornaMensagem();
    $Sessao::limpaMensagem();
    ?>

    <form action="<?php echo 'http://' . APP_HOST . '/usuario/authenticate'; ?>" method="post">
        <div>
            <label for="login">Login:</label>
            <input type="text" id="login" name="login" required>
        </div>
        <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>
