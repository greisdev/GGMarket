<?php
session_start();
include('config.php');

// Verifica se o usuário é administrador
if ($_SESSION['tipo_usuario'] != 'administrador') {
    header("Location: paginicial.php");
    exit();
}

$id = $_GET['id'];
$result = mysqli_query($conexao, "SELECT * FROM produto WHERE ID_produto='$id'");
$row = mysqli_fetch_assoc($result);

if (isset($_POST['editar'])) {
    $nome = $_POST['nome'];
    $foto = $_POST['foto'];
    $valor = $_POST['valor'];

    $sql = "UPDATE produto SET Nome='$nome', Foto='$foto', Valor='$valor' WHERE ID_produto='$id'";
    if (mysqli_query($conexao, $sql)) {
        echo "Produto atualizado com sucesso!";
    } else {
        echo "Erro: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/produtos.css">
    <title>Editar Produto</title>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="admin_produtos.php" class="back-button">Voltar</a>
        </div>
    </nav>

    <div class="form-box">
        <h1>Editar Produto</h1>
        <form method="post" action="editar_produto.php?id=<?php echo $id; ?>">
            <div class="input-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $row['Nome']; ?>" required>
            </div>
            <div class="input-group">
                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>
            </div>
            <div class="input-group">
                <label for="valor">Valor:</label>
                <input type="text" id="valor" name="valor" value="<?php echo $row['Valor']; ?>" required>
            </div>
            <button type="submit" name="editar">Editar Produto</button>
        </form>
    </div>
</body>

</html>