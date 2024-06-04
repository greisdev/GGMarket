<?php
session_start();
include('config.php'); 


if ($_SESSION['tipo_usuario'] != 'administrador') {
    header("Location: paginicial.php");
    exit();
}


$success_message = "";

// Cadastro de produto
if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $valor = (float) str_replace(',', '.', $_POST['valor']); 
    $usuario = $_SESSION['usuario_id'];


    $usuario_query = "SELECT * FROM usuario WHERE ID_usuario='$usuario'";
    $result_usuario = $conexao->query($usuario_query);
    if ($result_usuario->num_rows == 0) {
        echo "Usuário não encontrado.";
        exit();
    }

    
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];
        // Tratamento do upload da imagem
        $target_dir = "uploads/";
        $nome_arquivo = basename($foto["name"]);
        $target_file = $target_dir . $nome_arquivo;
        if (move_uploaded_file($foto["tmp_name"], $target_file)) {
            // Insere os dados no banco de dados
            $sql = "INSERT INTO produto (Nome, Foto, Valor, usuario) VALUES ('$nome', '$nome_arquivo', '$valor', '$usuario')";
            if ($conexao->query($sql) === TRUE) {
                $success_message = "Produto cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar produto: " . $conexao->error;
            }
        } else {
            echo "Erro ao fazer upload da imagem.";
        }
    } else {
        echo "Erro no upload da imagem. Certifique-se de que um arquivo foi selecionado e que não houve erros durante o envio.";
    }
}

// Remoção de produto
if (isset($_GET['remover'])) {
    $id = $_GET['remover'];
    $sql = "DELETE FROM produto WHERE ID_produto = '$id'";
    if ($conexao->query($sql) === TRUE) {
        $success_message = "Produto removido com sucesso!";
    } else {
        echo "Erro: " . $conexao->error;
    }
}


$sql = "SELECT * FROM produto";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Administração de Produtos</title>
    <link rel="stylesheet" href="Css/produtos.css">
</head>

<body>
    <nav class="navbar">
        <a href="paginicial.php" class="back-button">Voltar</a>
    </nav>

    <div class="container center-container">
        <div class="form-box">
            <h1>Administração de Produtos</h1>
            <?php if (!empty($success_message)) { ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            <?php } ?>
            <form method="post" action="admin_produtos.php" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div class="input-group">
                    <label for="foto">Foto:</label>
                    <input type="file" id="foto" name="foto" accept="image/*" required>
                </div>
                <div class="input-group">
                    <label for="valor">Valor:</label>
                    <input type="text" id="valor" name="valor" required>
                </div>
                <div class="input-group">
                    <button type="submit" name="cadastrar">Cadastrar Produto</button>
                </div>
            </form>

            <h2>Produtos Cadastrados</h2>
            <div class="products-container">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="product">
                        <p>Nome: <?php echo $row['Nome']; ?></p>
                        <?php
                        $foto_path = "uploads/" . $row['Foto'];
                        if (file_exists($foto_path)) {
                            echo '<img src="' . $foto_path . '" alt="' . $row['Nome'] . '">';
                        } else {
                            echo 'Imagem não encontrada';
                        }
                        ?>
                        <p>Valor: R$ <?php echo number_format($row['Valor'], 2, ',', '.'); ?></p>
                        <a href="editar_produto.php?id=<?php echo $row['ID_produto']; ?>" class="btn-editar">Editar</a>
                        <a href="admin_produtos.php?remover=<?php echo $row['ID_produto']; ?>" class="btn-excluir">Remover</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>