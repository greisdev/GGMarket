<?php
include_once('config.php');


$error_message = "";

// Verifica se o ID foi passado via GET
if (isset($_GET['ID'])) {
    $ID = (int)$_GET['ID']; 

    
    $sql = "DELETE FROM usuario WHERE ID_usuario=$ID";
    $result = $conexao->query($sql);

   
    if ($conexao->affected_rows > 0) {
        header('Location: perfil.php');
        exit();
    } else {
        $error_message = "Erro ao excluir usuário: " . $conexao->error;
    }
} else {
    $error_message = "Nenhum ID fornecido para exclusão.";
}


if (!empty($error_message)) {
    echo "<div class='error'>$error_message</div>";
}
