<?php
session_start();
include('config.php');

if (!isset($_SESSION['nome_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

if (isset($_GET['adicionar'])) {
    $id_produto = (int)$_GET['adicionar'];

    // Verificar se o produto existe no banco de dados
    $sql_check_product = "SELECT * FROM produto WHERE ID_produto = $id_produto";
    $result_check_product = $conexao->query($sql_check_product);

    if ($result_check_product->num_rows > 0) {
        $row = $result_check_product->fetch_assoc();
        $preco = $row['Valor'];
        $preco_total = $preco * 1; 

        
        $sql_check_cart_item = "SELECT * FROM carrinho WHERE id_usuario = $id_usuario AND id_produto = $id_produto";
        $result_check_cart_item = $conexao->query($sql_check_cart_item);

        if ($result_check_cart_item->num_rows > 0) {
         
            $sql_update_quantity = "UPDATE carrinho SET quantidade = quantidade + 1 WHERE id_usuario = $id_usuario AND id_produto = $id_produto";
            $conexao->query($sql_update_quantity);
        } else {
            
            $sql_add_to_cart = "INSERT INTO carrinho (id_usuario, id_produto, quantidade, preco_total) VALUES ($id_usuario, $id_produto, 1, $preco_total)";
            $conexao->query($sql_add_to_cart);
        }
        echo '<script>alert("O item foi adicionado ao carrinho!");</script>';
    } else {
        die('Você não pode adicionar um item que não existe.');
    }
}

if (isset($_GET['remover'])) {
    $id_produto = (int)$_GET['remover'];

    $sql_remove_from_cart = "DELETE FROM carrinho WHERE id_usuario = $id_usuario AND id_produto = $id_produto";
    $conexao->query($sql_remove_from_cart);
    echo '<script>alert("O item foi removido do carrinho!");</script>';
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="Css/carrinho.css">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="paginicial.php" class="back-button">Voltar</a>
        </div>
    </nav>

    <div class="container">
        <h2 class="title">Carrinho de Compras</h2>
        <div class="carrinho-container">
            <?php
            $sql_cart_items = "SELECT p.Nome, c.quantidade, p.Valor, c.id_produto FROM carrinho c INNER JOIN produto p ON c.id_produto = p.ID_produto WHERE c.id_usuario = $id_usuario";
            $result_cart_items = $conexao->query($sql_cart_items);

            while ($row = $result_cart_items->fetch_assoc()) {
            ?>
                <div class="carrinho-item">
                    <p>Nome: <?php echo $row['Nome']; ?> | Quantidade: <?php echo $row['quantidade']; ?> | Preço Total: R$<?php echo number_format($row['quantidade'] * $row['Valor'], 2, ',', '.'); ?></p>
                    <a class="remove-button" href="?remover=<?php echo $row['id_produto']; ?>">Remover</a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>