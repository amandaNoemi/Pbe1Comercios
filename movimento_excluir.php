<?php
session_start();
require_once 'config/conexao.php';

if (!isset($_SESSION['usuariologado'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? 0;

if ($id > 0) {

    $conexao = conectar();

    $sql = "SELECT * FROM movimento WHERE idMovimento = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $mov = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if ($mov && isset($mov['idProduto'])) {

        $idProduto = (int)$mov['idProduto'];
        $qtd = (int)$mov['quantidade'];

        if ($mov['tipoMovimento'] == 'SAIDA') {
            $sql = "UPDATE produto SET quantidade = quantidade + ? WHERE id = ?";
        } else {
            $sql = "UPDATE produto SET quantidade = quantidade - ? WHERE id = ?";
        }

        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $qtd, $idProduto);
        mysqli_stmt_execute($stmt);

        $sql = "DELETE FROM movimento WHERE idMovimento = ?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
    }

    mysqli_close($conexao);
}

header('Location: movimento.php');
exit;
?>