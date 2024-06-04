<?php
session_start();


if (isset($_POST['remover_item'])) {
    $id_produto = $_POST['id_produto'];

    // Verificar se o ID do produto está presente no carrinho
    if (isset($_SESSION['carrinho'][$id_produto])) {
        unset($_SESSION['carrinho'][$id_produto]);
        echo '<script>alert("Item removido do carrinho com sucesso.");</script>';
    } else {
        echo '<script>alert("O item selecionado não está no carrinho.");</script>';
    }

   
    header("Location: carrinho.php");
    exit();
}
