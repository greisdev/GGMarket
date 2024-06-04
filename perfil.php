<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit(); 
}

// Obtém o ID do usuário logado
$usuario_id = $_SESSION['usuario_id'];

include_once('config.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuário</title>
    <link rel="stylesheet" href="Css/perfil.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="paginicial.php" class="back-button">Voltar</a>
    </nav>

    <div class="container">
    <div class="form-box">
        <div class="input-group">
            <h2>Editar usuário</h2>
            <div>
                <?php
                $result = mysqli_query($conexao, "SELECT ID_usuario, Nome, Email, Senha, Telefone FROM usuario WHERE ID_usuario = $usuario_id");

                
                if ($result) { 
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>ID</th>";
                        echo "<th>Login</th>";
                        echo "<th>Senha</th>";
                        echo "<th>Email</th>";
                        echo "<th>Telefone</th>";
                        echo "<th>Ações</th>";
                        echo "</tr>";

                      
                        while ($registro = mysqli_fetch_array($result)) {
                            $id = $registro['ID_usuario'];
                            $nome = $registro['Nome'];
                            $email = $registro['Email'];
                            $senha = $registro['Senha'];
                            $telefone = $registro['Telefone'];

                            echo "<tr>";
                            echo "<td>$id</td>";
                            echo "<td>$nome</td>";
                            echo "<td>$senha</td>";
                            echo "<td>$email</td>";
                            echo "<td>$telefone</td>";
                            echo "<td><a href='perfiledit.php?ID=$id' class='btn-editar'>EDITAR</a> <a href='excluir_informacao.php?ID=$id' class='btn-excluir'>EXCLUIR</a></td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                    } else {
                        echo "Não há registros na tabela.";
                    }
                } else {
        
                    echo "Erro na consulta SQL: " . mysqli_error($conexao);
                }
                ?>
            </div>
        </div>
    
        <?php if ($_SESSION['tipo_usuario'] === 'administrador'): ?>
            <div class="input-group">
                <a href="admin_produtos.php" class="gerenciamento-produtos-link">Gerenciamento de produtos</a>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>

</html>