<?php
session_start();
require_once 'config/conexao.php';
if (!isset($_SESSION['usuariologado'])) {
    header('Location: login.php');
    exit;
}   

$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id > 0) {
    $conexao = conectar();
    $sql = "DELETE FROM produto WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conexao);
}
header('Location: produto.php');
exit;
?>