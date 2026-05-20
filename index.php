<?php
$titulo_pagina = 'Página Inicial';
require_once 'templates/header.php';
?>

<div class="container">
    <?php if (isset($_SESSION['usuariologado'])): ?>
        <!-- Conteúdo para usuário LOGADO -->
        <h1>Bem-vindo de volta, <?= htmlspecialchars($_SESSION['usuariologado']) ?>!</h1>
        <p>Você está na área administrativa do sistema. Use o menu abaixo para navegar.</p>
        
        <div class="dashboard">
            <!-- Card Produtos -->
            <a href="produto.php" class="card">
                <h2>Gerenciar Produtos</h2>
                <p>Adicionar, editar e visualizar o catálogo de produtos.</p>
            </a>
            
            <!-- Card Clientes -->
            <a href="cliente.php" class="card">
                <h2>Gerenciar Clientes</h2>
                <p>Adicionar, editar e visualizar a carteira de clientes.</p>
            </a>
            
            <!-- Card Estoque (Movimentações) -->
            <a href="movimento.php" class="card">
                <h2>Gerenciar Estoque</h2>
                <p>Registrar entradas, saídas e visualizar histórico.</p>
            </a>
        </div>

    <?php else: ?>
        <!-- Conteúdo para VISITANTE -->
        <h1>Bem-vindo à PBE1 Comércios</h1>
        <p>A sua loja online de produtos de tecnologia.</p>
        <p>Para gerenciar o sistema, por favor, faça o login.</p>
        <a href="login.php" class="cta-button">Ir para o Login</a>
    <?php endif; ?>
</div>

<?php require_once 'templates/footer.php'; ?>

