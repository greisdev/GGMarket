<?php
include_once('config.php');

// Verifica se os dados foram submetidos via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST['ID'];
    $login = $_POST['nome'];
    $email = $_POST['email']; 
    $telefone = $_POST['telefone']; 
    $senha = $_POST['senha'];

    // Consulta SQL para atualizar os dados
    $sql = "UPDATE usuario SET Nome=?, Email=?, Telefone=?, Senha=? WHERE ID_usuario=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssssi", $login, $email, $telefone, $senha, $ID);
    $stmt->execute();

 
    header('Location: perfil.php');
    exit(); 
}
