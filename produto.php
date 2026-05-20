<?php
//importação do cabeçalho
$titulopagina = "Pbe1 ComerciOS - Produto";
require_once "templates/header.php";
//verificando se o usuário está logado
if (!isset($_SESSION['usuariologado'])) {
    header("Location: login.php");
    exit;
}
//trecho de inclusão de produtos
$mensagem = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nomeProduto'], $_POST['categoria'], $_POST['preco'], $_POST['quantidade'], $_POST['acao'])) {
        $nomeProduto = $_POST['nomeProduto'];
        $categoria = $_POST['categoria'];
        $preco = (float)$_POST['preco'];
        $quantidade = (int)$_POST['quantidade'];
        $acao = $_POST['acao'];

        if ($acao == 'salvar') {
            $conexao = conectar();
            $sql = "INSERT INTO produto (nomeProduto, categoria, preco, quantidade) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conexao, $sql);
            mysqli_stmt_bind_param($stmt, "ssdi", $nomeProduto, $categoria, $preco, $quantidade);
            mysqli_stmt_execute($stmt);
            mysqli_close($conexao);
            header("Location: produto.php");
            exit;
        }
    }
}
//techo de limpeza da lista
if (isset($_GET['limpar']) && $_GET['limpar'] == true) {
    $_SESSION['mensagemGrupo'] = [];
    header("Location: produto.php");
    exit;
}
//trecho de pesquisa no banco de dados
$conexao = conectar();
$produtos = [];

$busca = isset($_GET['busca']) ? trim($_GET['busca'])  : '';
$campo = isset($_GET['campo']) ? $_GET['campo'] : 'nomeProduto';

if (!$busca !== '') {
    $sql = "SELECT * FROM produto WHERE $campo LIKE ? ORDER BY nomeProduto";
    $stmt = mysqli_prepare($conexao, $sql);
    $termo_busca = '%' . $busca . '%';
    mysqli_stmt_bind_param($stmt, "s", $termo_busca);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);


} else {
       $sql = "SELECT * FROM produto ORDER BY $ nomeProduto";
      $resultado = mysqli_query($conexao, $sql);
    }
if ($resultado && mysqli_num_rows($resultado) > 0) {
    $produtos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}   
mysqli_close($conexao);


?>
<div class="page-layout-produto">
    <div class="form-container">
        <h1>Cadastro de Produtos</h1>
        <form action="produto.php" method="post">
            <label for="nomeProduto">Nome do Produto: </label>
            <input type="text" name="nomeProduto" id="nomeProduto">
            <label for="categoria">Categoria: </label>
            <input type="text" name="categoria" id="categoria">
            <label for="preco">Preço: </label>
            <input type="number" step="0.01" name="preco" id="preco">
            <label for="quantidade">Quantidade: </label>
            <input type="text" name="quantidade" id="quantidade">
            <button type="submit" name="acao" value="salvar">Salvar</button>
        </form>
    </div>
    <div class="list-container">
        <h1>Nossos Produtos</h1>

        <form action="produto.php" method="get" class="search-form">
            <input type="text" placeholder="Buscar Produtos..." name="busca" value="<?=$busca?>">
            <select name="campo">
                <option value="nomeProduto" <?= $campo == 'nomeProduto' ? 'selected' : '' ?>>Nome</option>
                <option value="categoria" <?= $campo == 'categoria' ? 'selected' : '' ?>>Categoria</option>
                <option value="preco" <?= $campo == 'preco' ? 'selected' : '' ?>>Preço</option>
                <option value="quantidade" <?= $campo == 'quantidade' ? 'selected' : '' ?>>Quantidade</option>
            </select>
            <button type="submit" name="acao" value="buscar">Buscar</button>
            <?php if ($busca !== ''): ?>
            <button class="btn-clean"> <a href="produto.php">Limpar</a></button>
            <?php endif; ?>
        </form>


        <!--trecho de exibição dos produtos-->
        <?php if (count($produtos) > 0): ?>
            <div class="product-grid">
                <?php foreach ($produtos as $produto): ?>
                    <div class="product-card">
                        <h3><?= $produto['nomeProduto'] ?></h3>
                        <p><strong>Categoria: </strong><?= $produto['categoria'] ?></p>
                        <p><strong>Preço: </strong><?= number_format($produto['preco'], 2, ",", ".") ?></p>
                        <p><strong>Quantidade: </strong><?= $produto['quantidade'] ?></p>
                        <div class="product-actions">
                            <a href="produto_editar.php?id=<?= $produto['id'] ?>" class="btn-edit">Editar</a>

<a href="produto_excluir.php?id=<?= $produto['id'] ?>"
   class="btn-delete"
   onclick="return confirm('Tem certeza que deseja excluir o produto?')">
   Excluir
</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Nenhum produto cadastrado no Banco de Dados.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once "templates/footer.php"; ?>