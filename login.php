<?php
include_once('config.php');


$error_message = "";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

   
    $query = "SELECT ID_usuario, Nome, tipo_usuario FROM usuario WHERE Email='$email' AND Senha='$senha'";
    $result = $conexao->query($query);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        session_start();
        $_SESSION['usuario_id'] = $usuario['ID_usuario']; // Definir o ID do usuário na sessão
        $_SESSION['nome_usuario'] = $usuario['Nome']; // Definir o nome do usuário na sessão
        $_SESSION['tipo_usuario'] = $usuario['tipo_usuario']; // Definir o tipo do usuário na sessão

        
        if ($usuario['tipo_usuario'] == 'administrador') {
            header('Location: admin_produtos.php');
            exit();
        } else {
            header('Location: paginicial.php'); 
            exit();
        }
    } else {
        $error_message = "Credenciais inválidas. Por favor, tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Css/login.css">
</head>

<body>
    <nav class="navbar">
        <a href="cadastro.php" class="back-button">Voltar</a>
    </nav>

    <div class="form-box">
        <div class="img-box">
            <img src="Img/user.png" alt="user" class="img-box">
        </div>
        <h2>Login</h2>
        <p>Ainda não é membro? <a href="cadastro.php">Crie uma conta</a></p>
        <?php if (!empty($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>

        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Digite o seu email" required>
            </div>
            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            </div>
            <div class="input-group">
                <button type="submit" name="submit">Entrar</button>
            </div>
        </form>
    </div>
</body>

</html>