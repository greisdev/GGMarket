<?php
include_once('config.php');

if (isset($_POST['submit'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];
    $tipo_usuario = $_POST['tipo_usuario'];

    
    if (!empty($nome) && !empty($email) && !empty($telefone) && !empty($senha) && !empty($tipo_usuario)) {
        
        $check_email_query = "SELECT * FROM usuario WHERE email='$email'";
        $result_email = $conexao->query($check_email_query);

        if ($result_email->num_rows > 0) {
            $error_message = "Este e-mail já está cadastrado.";
        } else {
            
            $check_telefone_query = "SELECT * FROM usuario WHERE telefone='$telefone'";
            $result_telefone = $conexao->query($check_telefone_query);

            if ($result_telefone->num_rows > 0) {
                $error_message = "Este telefone já está cadastrado.";
            } else {
                // Insere os dados no banco de dados
                $query = "INSERT INTO usuario (nome, email, telefone, senha, tipo_usuario) 
                          VALUES ('$nome', '$email', '$telefone', '$senha', '$tipo_usuario')";
                $result = $conexao->query($query);

                if ($result) {
                    header('Location: login.php');
                    exit();
                } else {
                    $error_message = "Erro ao cadastrar usuário. Por favor, tente novamente.";
                }
            }
        }
    } else {
        $error_message = "Todos os campos são obrigatórios.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="Css/style.css">
</head>

<body>
    <div class="box">
        <div class="img-box">
            <img src="Img/background.png" alt="mercado">
        </div>
        <div class="form-box">
            <h2>Criar Conta</h2>
            <p>Já é um membro? <a href="login.php">Login</a></p>

            <?php if (!empty($error_message)) { ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php } ?>

            <form action="cadastro.php" method="POST">
                <div class="input-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" placeholder="Digite o seu nome completo" required>
                </div>
                <div class="input-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="Digite o seu email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Por favor, insira um email válido." required>
                </div>
                <div class="input-group">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" placeholder="(00) 00000-0000" pattern="\([0-9]{2}\)\s[0-9]{5}-[0-9]{4}" title="Por favor, insira um número de telefone válido." required>
                </div>
                <div class="input-group w50">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" title="A senha deve conter pelo menos 8 caracteres, incluindo pelo menos uma letra maiúscula, uma letra minúscula, um número e um símbolo." required>
                </div>
                <div class="input-group">
                    <label for="tipo_usuario">Tipo de Usuário</label>
                    <select name="tipo_usuario" id="tipo_usuario" required>
                        <option value="usuario">Usuário Comum</option>
                        <option value="administrador">Administrador</option>
                    </select>
                </div>

                <div class="input-group">
                    <button type="submit" name="submit">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Formatação dinâmica do número de telefone
        document.getElementById('telefone').addEventListener('input', function(e) {
            var phoneNumber = e.target.value.replace(/\D/g, '');
            var formattedPhoneNumber = '';

            // Formatação do número de telefone
            if (phoneNumber.length > 0) {
                formattedPhoneNumber += '(' + phoneNumber.substring(0, 2) + ') ';
            }
            if (phoneNumber.length > 2) {
                formattedPhoneNumber += phoneNumber.substring(2, 7) + '-';
            }
            if (phoneNumber.length > 7) {
                formattedPhoneNumber += phoneNumber.substring(7, 11);
            }

            e.target.value = formattedPhoneNumber; 
        });
    </script>
</body>

</html>