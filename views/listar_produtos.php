<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

include __DIR__ . '/../database/conexao.php';

$produtos = $conn->query("SELECT * FROM produtos ORDER BY criado_em DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Produtos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">
    <h2 class="mb-3">Listagem de Produtos</h2>

    <a href="cadastrar_produto.php" class="btn btn-primary mb-3">Novo Produto</a>
    <a href="logout.php" class="btn btn-secondary mb-3">Sair</a>

    <?php if (isset($_SESSION['erro'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['erro']; unset($_SESSION['erro']); ?>
        </div>
    <?php endif; ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Valor</th>
                <th>Quantidade</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php while($p = $produtos->fetch_assoc()): ?>
            <tr>
                <td><?= $p['codigo'] ?></td>
                <td><?= $p['nome'] ?></td>
                <td>R$ <?= number_format($p['valor'], 2, ',', '.') ?></td>
                <td><?= $p['quantidade'] ?></td>
                <td><?= $p['status'] ?></td>
                <td>
                    <a class="btn btn-info btn-sm" href="editar_produto.php?id=<?= $p['id'] ?>">Editar</a>

                    <form method="POST" action="../controllers/produto.php" style="display:inline;">
                        <input type="hidden" name="action" value="excluir">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Excluir este produto?')">Excluir</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>

    </table>
</div>

<script src="../assets/js/script.js"></script>


</body>
</html>
