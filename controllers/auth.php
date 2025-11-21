<?php
session_start();
include __DIR__ . '/../database/conexao.php';

$action = $_POST['action'] ?? '';

if ($action === 'login') {
    
    $email = $_POST['email'];
    $senha = md5($_POST['senha']); 

    $stmt = $conn->prepare("SELECT id, email FROM usuarios WHERE email = ? AND senha = ?");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $_SESSION['usuario'] = $email;
        header("Location: ../views/listar_produtos.php");
        exit;
    } else {
        $_SESSION['erro'] = "Email ou senha inválidos";
        header("Location: ../views/login.php");
        exit;
    }
}
?>
