<?php
session_start();
include __DIR__ . '/../database/conexao.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'criar') {

    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'] !== '' ? floatval(str_replace(',', '.', $_POST['valor'])) : 0;
    $quantidade = intval($_POST['quantidade']);
    $status = $_POST['status'];

    $check = $conn->prepare("SELECT id FROM produtos WHERE codigo = ?");
    $check->bind_param("s", $codigo);
    $check->execute();

    if ($check->get_result()->num_rows > 0) {
        $_SESSION['erro'] = "Código já existe!";
        header("Location: ../views/cadastrar_produto.php");
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO produtos (codigo, nome, descricao, valor, quantidade, status)
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdis", $codigo, $nome, $descricao, $valor, $quantidade, $status);
    $stmt->execute();

    header("Location: ../views/listar_produtos.php");
    exit;
}


if ($action === 'atualizar') {

    $id = intval($_POST['id']);
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $valor = floatval($_POST['valor']);
    $quantidade = intval($_POST['quantidade']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE produtos 
                            SET nome=?, descricao=?, valor=?, quantidade=?, status=? 
                            WHERE id=?");
    $stmt->bind_param("ssdisi", $nome, $descricao, $valor, $quantidade, $status, $id);
    $stmt->execute();

    header("Location: ../views/listar_produtos.php");
    exit;
}

if ($action === 'excluir') {


    $p = $conn->prepare("SELECT status, quantidade FROM produtos WHERE id=?");
    $p->bind_param("i", $id);
    $p->execute();

    $res = $p->get_result()->fetch_assoc();

    if ($res['status'] === 'ativo' || $res['quantidade'] > 0) {
        $_SESSION['erro'] = "Não é possível excluir: produto ativo ou com quantidade > 0.";
        header("Location: ../views/listar_produtos.php");
        exit;
    }

    $del = $conn->prepare("DELETE FROM produtos WHERE id=?");
    $del->bind_param("i", $id);
    $del->execute();

    header("Location: ../views/listar_produtos.php");
    exit;
}
?>
