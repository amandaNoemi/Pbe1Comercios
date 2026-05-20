<?php
session_start();
require_once 'config/conexao.php';

if (!isset($_SESSION['usuariologado'])) {
    header('Location: login.php');
    exit;
}

$conexao = conectar();

$id = $_GET['id'] ?? 0;

if ($id > 0) {

    $sql = "DELETE FROM cliente WHERE id = ?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);
}

mysqli_close($conexao);

header('Location: cliente.php');
exit;
?>