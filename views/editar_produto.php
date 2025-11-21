<?php
session_start();
if (!isset($_SESSION['usuario'])) { 
    header("Location: login.php"); 
    exit;
}

include __DIR__ . '/../database/conexao.php';

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM produtos WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$produto = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
<title>Editar Produto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">
    <h2>Editar Produto</h2>

    <form method="POST" action="../controllers/produto.php">
        <input type="hidden" name="action" value="atualizar">
        <input type="hidden" name="id" value="<?= $produto['id'] ?>">

        <div class="mb-3">
            <label>Código (não pode editar)</label>
            <input type="text" class="form-control" value="<?= $produto['codigo'] ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="<?= $produto['nome'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Descrição</label>
            <textarea name="descricao" class="form-control"><?= $produto['descricao'] ?></textarea>
        </div>

        <div class="mb-3">
            <label>Valor</label>
            <input type="text" name="valor" class="form-control" value="<?= $produto['valor'] ?>">
        </div>

        <div class="mb-3">
            <label>Quantidade</label>
            <input type="number" name="quantidade" class="form-control" value="<?= $produto['quantidade'] ?>">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="ativo"   <?= $produto['status']=='ativo'?'selected':'' ?>>Ativo</option>
                <option value="inativo" <?= $produto['status']=='inativo'?'selected':'' ?>>Inativo</option>
            </select>
        </div>

        <button class="btn btn-success">Salvar</button>
        <a href="listar_produtos.php" class="btn btn-secondary">Voltar</a>
    </form>

</div>

<script src="../assets/js/script.js"></script>

</body>
</html>
