<?php
session_start();
include('config.php');

if (!isset($_SESSION['nome_usuario'])) {
    header('Location: login.php');
    exit();
}

$nome_usuario = $_SESSION['nome_usuario'];

$sql = "SELECT * FROM produto";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $sql .= " WHERE Nome LIKE '%$search%'";
}
$result = $conexao->query($sql);
$produtos_db = array();

while ($row = $result->fetch_assoc()) {
    $produtos_db[] = array(
        'ID_produto' => $row['ID_produto'],
        'nome' => $row['Nome'],
        'imagem' => 'uploads/' . $row['Foto'],
        'preco' => $row['Valor']
    );
}

if (isset($_GET['adicionar'])) {
    $id_produto = (int)$_GET['adicionar'];
    if (isset($produtos_db[$id_produto])) {
        $item = $produtos_db[$id_produto];
        if (!isset($_SESSION['carrinho'][$id_produto])) {
            $_SESSION['carrinho'][$id_produto] = array(
                'nome' => $item['nome'],
                'preco' => $item['preco'],
                'quantidade' => 1
            );
        } else {
            $_SESSION['carrinho'][$id_produto]['quantidade']++;
        }
        echo '<script>alert("O item foi adicionado ao carrinho!");</script>';
    } else {
        die('Você não pode adicionar um item que não existe.');
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de produtos</title>
    <link rel="stylesheet" href="Css/paginicial.css">
</head>

<body>
    <div class="navbar">
        <div class="search-container">
            <form action="#" method="GET">
                <input type="text" placeholder="Buscar produtos..." name="search">
                <button type="submit">Buscar</button>
            </form>
        </div>
        <div class="usuario">
            <h1>Bem-vindo, <?php echo $nome_usuario; ?>!</h1>
        </div>
        <div class="user">
            <a href="perfil.php">
                <img src="Img/user.png" alt="Usuário">
            </a>
        </div>
        <div class="cart">
            <a href="carrinho.php">
                <img src="Img/carrinho.png" alt="Carrinho de Compras">
            </a>
        </div>
        <div class="logout">
            <form action="logout.php" method="post">
                <a href="login.php">
                    <img src="Img/logout.png" alt="Logout">
                </a>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="white-box">
            <div class="items">
                <?php foreach ($produtos_db as $item) { ?>
                    <div class="item">
                        <div class="product">
                            <img src="<?php echo $item['imagem']; ?>" alt="<?php echo $item['nome']; ?>">
                        </div>
                        <h3><?php echo $item['nome']; ?></h3>
                        <span>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></span>
                        <a href="carrinho.php?adicionar=<?php echo $item['ID_produto']; ?>">Comprar</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>