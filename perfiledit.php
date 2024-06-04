<?php
include_once('config.php');

// Verifica se o ID foi passado via GET
if (isset($_GET['ID'])) {
    $ID = $_GET['ID'];


    $sql = "SELECT * FROM usuario WHERE ID_usuario = $ID";
    $result = $conexao->query($sql);

    
    if ($result->num_rows > 0) {
        while ($registro = $result->fetch_assoc()) {
            $login = $registro['Nome'];
            $email = $registro['Email'];
            $telefone = $registro['Telefone'];
            $senha = $registro['Senha'];
        }
    } else {
        echo "Nenhum usuário encontrado com o ID fornecido.";
        exit; 
    }
} else {
    echo "Nenhum ID fornecido na URL.";
    exit; 
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editando perfil</title>
    <link rel="stylesheet" href="Css/login.css">
</head>

<body>
    <nav class="navbar">
        <a href="perfil.php" class="back-button">Voltar</a>
    </nav>
    <div class="form-box">
        <h2>Editando Perfil</h2>
        <form action="save_edit.php" method="POST">
            <!-- Adicionando um campo oculto para enviar o ID do usuário -->
            <input type="hidden" name="ID" value="<?php echo $ID; ?>">

            <div class="input-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o seu nome completo" value="<?php echo $login; ?>" required>
            </div>
            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Digite o seu email" value="<?php echo $email; ?>" required>
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
                <button type="submit" name="update" value="editar">Editar</button>
            </div>
        </form>
    </div>
    <script>
        
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