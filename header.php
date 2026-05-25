<?php
session_start();
require_once 'config/conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo_pagina ?? 'PBE1 Comércios' ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="main-header">
        <div class="logo">PBE1 Comércios</div>
        <nav>
            <a href="home.php">Home</a>
            <?php if (isset($_SESSION['usuariologado'])): ?>
                <a href="produto.php">Produtos</a>
                <a href="cliente.php">Clientes</a>
                <a href="movimento.php">Movimentações</a>
                <a href="logout.php" class="logout">Sair</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>