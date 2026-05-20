<?php
$titulopagina = "PBE1ComérciOS - Movimento";
require_once "templates/header.php";

if (!isset($_SESSION['usuariologado'])) {
    header('Location: login.php');
    exit;
}

$mensagem = "";

/* =========================
   REGISTRO DE MOVIMENTO
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['idCliente'], $_POST['idProduto'], $_POST['tipoMovimento'], $_POST['qtdmovimentar'], $_POST['observacao'], $_POST['acao'])) {

        $idCliente = !empty($_POST['idCliente']) ? (int)$_POST['idCliente'] : NULL;
        $idProduto = (int)$_POST['idProduto'];
        $tipoMovimento = $_POST['tipoMovimento'];
        $qtdmovimentar = (int)$_POST['qtdmovimentar'];
        $observacao = $_POST['observacao'];
        $acao = $_POST['acao'];

        if ($acao == "registrar") {

            $conexao = conectar();

            /* =========================
               BUSCA PRODUTO
            ========================= */
            $sql = "SELECT * FROM produto WHERE id = ?";
            $stmt = mysqli_prepare($conexao, $sql);
            mysqli_stmt_bind_param($stmt, "i", $idProduto);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            $produto = mysqli_fetch_assoc($resultado);

            if ($produto) {

                if (
                    ($tipoMovimento == "SAIDA" && $qtdmovimentar > 0 && $qtdmovimentar <= $produto['quantidade'])
                    ||
                    ($tipoMovimento == "ENTRADA" && $qtdmovimentar > 0)
                ) {

                    if ($tipoMovimento == "SAIDA") {
                        $novaquantidade = $produto['quantidade'] - $qtdmovimentar;
                    } else {
                        $novaquantidade = $produto['quantidade'] + $qtdmovimentar;
                    }

                    /* =========================
                       ATUALIZA ESTOQUE
                    ========================= */
                    $sql = "UPDATE produto SET quantidade = ? WHERE id = ?";
                    $stmt = mysqli_prepare($conexao, $sql);
                    mysqli_stmt_bind_param($stmt, "ii", $novaquantidade, $idProduto);
                    mysqli_stmt_execute($stmt);

                    /* =========================
                       INSERE MOVIMENTO
                    ========================= */
                    $sql = "INSERT INTO movimento (idProduto, idCliente, tipoMovimento, quantidade, dataMovimento, observacao)
                            VALUES (?, ?, ?, ?, NOW(), ?)";

                    $stmt = mysqli_prepare($conexao, $sql);
                    mysqli_stmt_bind_param(
                        $stmt,
                        "iisis",
                        $idProduto,
                        $idCliente,
                        $tipoMovimento,
                        $qtdmovimentar,
                        $observacao
                    );

                    mysqli_stmt_execute($stmt);

                    $mensagem = "Movimento registrado com sucesso.";

                } else {
                    $mensagem = "Quantidade inválida.";
                }

            } else {
                $mensagem = "Produto não encontrado.";
            }

            mysqli_close($conexao);

            header("Location: movimento.php");
            exit;
        }
    }
}

/* =========================
   LISTA PRODUTOS
========================= */
$conexao = conectar();

$sqlprodutos = "SELECT id, nomeProduto, quantidade FROM produto ORDER BY nomeProduto";
$resultado = mysqli_query($conexao, $sqlprodutos);
$lista_produtos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

/* =========================
   LISTA CLIENTES
========================= */
$sqlclientes = "SELECT id, nomeCliente FROM cliente ORDER BY nomeCliente";
$resultado = mysqli_query($conexao, $sqlclientes);
$lista_clientes = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

/* =========================
   LISTA MOVIMENTOS
========================= */
$sqlmovimentos = "
SELECT m.*, p.nomeProduto, c.nomeCliente
FROM movimento m
INNER JOIN produto p ON m.idProduto = p.id
INNER JOIN cliente c ON m.idCliente = c.id
ORDER BY m.dataMovimento DESC
";

$resultado = mysqli_query($conexao, $sqlmovimentos);
$lista_movimentos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

mysqli_close($conexao);
?>

<!-- =========================
     HTML
========================= -->

<div class="page-layout-produto">

    <div class="form-container">

        <h1>Registro de Movimentos</h1>

        <form method="POST">

            <label>Produto:</label>
            <select name="idProduto">
                <option value=""> Selecione </option>
                <?php foreach ($lista_produtos as $p): ?>
                    <option value="<?= $p['id'] ?>">
                        <?= $p['nomeProduto'] ?> (<?= $p['quantidade'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Cliente:</label>
            <select name="idCliente">
                <option value=""> Selecione </option>
                <?php foreach ($lista_clientes as $c): ?>
                    <option value="<?= $c['id'] ?>">
                        <?= $c['nomeCliente'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Tipo:</label>
            <select name="tipoMovimento">
                <option value="s">Selecione</option>
                <option value="SAIDA">Saída</option>
                <option value="ENTRADA">Entrada</option>
            </select>

            <label>Quantidade:</label>
            <input type="number" name="qtdmovimentar">

            <label>Observação:</label>
            <input type="text" name="observacao">

            <button type="submit" name="acao" value="registrar">Registrar</button>

        </form>

    </div>

    <div class="list-container">

        <h1>Histórico</h1>
        <h3><?= $mensagem ?></h3>

        <?php if (count($lista_movimentos) > 0): ?>

            <div class="product-grid">

                <?php foreach ($lista_movimentos as $m): ?>
                    

                    <div class="product-card">
                        

                        <h3><?= $m['nomeProduto'] ?></h3>

                        <p>Tipo: <?= $m['tipoMovimento'] ?></p>
                        <p>Qtd: <?= $m['quantidade'] ?></p>
                        <p>Data: <?= $m['dataMovimento'] ?></p>
                        <p>Cliente: <?= $m['nomeCliente'] ?></p>
                        <p>Obs: <?= $m['observacao'] ?></p>

                        <div class="product-actions">

   

   

</div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <p>Nenhum movimento registrado.</p>

        <?php endif; ?>

    </div>

</div>

<?php require_once "templates/footer.php"; ?>