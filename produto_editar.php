<?php
$titulopagina = "Pbe1 ComerciOS - Produto Editar";
require_once "templates/header.php";

if (!isset($_SESSION['usuariologado'])) {
    header('Location: login.php');
    exit;
}



//trecho para atualizar (Uploud)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nomeProduto'], $_POST['categoria'], $_POST['preco'], $_POST['quantidade'], $_POST['acao'])) {
        $id = $_POST['id'];
        $nomeProduto = $_POST['nomeProduto'];
        $categoria = $_POST['categoria'];
        $preco = (float)$_POST['preco'];
        $quantidade = (int)$_POST['quantidade'];
        $acao = $_POST['acao'];

        if ($acao == 'salvar') {
            $conexao = conectar();
            $sql = "UPDATE produto SET nomeProduto = ?, categoria = ?, preco = ?, quantidade = ? WHERE id = ?";
            $stmt = mysqli_prepare($conexao, $sql);
            mysqli_stmt_bind_param($stmt, "ssdii", $nomeProduto, $categoria, $preco, $quantidade, $id);
            mysqli_stmt_execute($stmt);
            mysqli_close($conexao);
            header("Location: produto.php");
            exit;
        }
    }
}

$produto = null;
$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id > 0) {
    $conexao = conectar();
    $sql = "SELECT * FROM produto WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $produto = mysqli_fetch_assoc(($resultado));
    mysqli_close($conexao);
}
if (!$produto) {
    header('Location: produto.php');
    exit;
}

?>
<div class="page-layout-produto">
    <div class="form-container">
        <h1>Edição de Produtos</h1>
        <form action="produto_editar.php" method="post">
            <input type="hidden" name="id" value="<?= $produto['id']; ?>">    
            <label for="nomeProduto">Nome do Produto: </label>
            <input type="text" name="nomeProduto" id="nomeProduto" value="<?= $produto['nomeProduto']; ?>" required>
            <label for="categoria">Categoria: </label>
            <input type="text" name="categoria" id="categoria" value="<?= $produto['categoria']; ?>" required>
            <label for="preco">Preço: </label>
            <input type="number" name="preco" id="preco" value="<?= $produto['preco']; ?>" required>
            <label for="quantidade">Quantidade: </label>
            <input type="text" name="quantidade" id="quantidade" value="<?= $produto['quantidade']; ?>" required>
            <button type="submit" name="acao" value="salvar">Salvar</button>
        </form>
    </div>
</div>
<?php require_once "templates/footer.php";  ?>