<?php
//importação do cabeçalho
$titulopagina = "Pbe1 ComerciOS - Cliente";
require_once "templates/header.php";
//verificando se o usuário está logado
if (!isset($_SESSION['usuariologado'])) {
    header("Location: login.php");
    exit;
}
//trecho de inclusão de clientes
$mensagem = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nomeCliente'], $_POST['email'], $_POST['telefone'], $_POST['estadoCivil'], $_POST['quantidadeDependentes'], $_POST['renda'], $_POST['acao'])) {
        $nomeCliente = $_POST['nomeCliente'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $estadoCivil = $_POST['estadoCivil'];
        $quantidadeDependentes = (int)$_POST['quantidadeDependentes'];
        $renda = (float)$_POST['renda'];
        $acao = $_POST['acao'];

        if ($acao == 'salvar') {
            $conexao = conectar();
            $sql = "INSERT INTO cliente (nomeCliente, email, telefone, estadoCivil, quantidadeDependentes, renda) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conexao, $sql);
            mysqli_stmt_bind_param($stmt, "ssssid", $nomeCliente, $email, $telefone, $estadoCivil, $quantidadeDependentes, $renda);
            mysqli_stmt_execute($stmt);
            mysqli_close($conexao);
            header("Location: cliente.php");
            exit;
        }
    }
}
//techo de limpeza da lista
if (isset($_GET['limpar']) && $_GET['limpar'] == true) {
    $_SESSION['mensagemGrupo'] = [];
    header("Location: cliente.php");
    exit;
}
//trecho de pesquisa no banco de dados
$conexao = conectar();
$clientes = [];

$busca = isset($_GET['busca']) ? trim($_GET['busca'])  : '';
$campo = isset($_GET['campo']) ? $_GET['campo'] : 'nomeCliente';

if (!$busca !== '') {
    $sql = "SELECT * FROM cliente WHERE $campo LIKE ? ORDER BY nomeCliente";
    $stmt = mysqli_prepare($conexao, $sql);
    $termo_busca = '%' . $busca . '%';
    mysqli_stmt_bind_param($stmt, "s", $termo_busca);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
} else {
    $sql = "SELECT * FROM cliente ORDER BY $ nomeCliente";
    $resultado = mysqli_query($conexao, $sql);
}
if ($resultado && mysqli_num_rows($resultado) > 0) {    
    $clientes = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}
mysqli_close($conexao);



?>
<div class="page-layout-produto">
    <div class="form-container">
        <h1>Cadastro de Clientes</h1>
        <form action="cliente.php" method="post">
            <label for="nomeCliente">Nome do Cliente: </label>
            <input type="text" name="nomeCliente" id="nomeCliente">
            <label for="email">Email: </label>
            <input type="text" name="email" id="email">
            <label for="telefone">Telefone: </label>
            <input type="number" name="telefone" id="telefone">
            <label for="quantidade">Estado Civil: </label>
            <input type="text" name="estadoCivil" id="estadoCivil">
            <label for="quantidadeDependentes">Quantidade de Dependentes </label>
            <input type="number" name="quantidadeDependentes" id="quantidadeDependentes">
            <label for="renda">Renda</label>
            <input type="number" name="renda" id="renda">
            <button type="submit" name="acao" value="salvar">Salvar</button>
        </form>
    </div>
    <div class="list-container">
        <h1>Nossos Clientes</h1>

        <form action="cliente.php" method="get" class="search-form">
            <input type="text" placeholder="Buscar Clientes..." name="busca" value="<?= $busca ?>">
            <select name="campo">
                <option value="nomeCliente" <?= $campo == 'nomeCliente' ? 'selected' : '' ?>>Nome</option>
                <option value="email" <?= $campo == 'email' ? 'selected' : '' ?>>Email</option>
                <option value="telefone" <?= $campo == 'telefone' ? 'selected' : '' ?>>Telefone</option>
                <option value="estadoCivil" <?= $campo == 'estadoCivil' ? 'selected' : '' ?>>Estado Civil</option>
                <option value="quantidadeDependentes" <?= $campo == 'quantidadeDependentes' ? 'selected' : '' ?>>Quantidade de Dependentes</option>
                <option value="renda" <?= $campo == 'renda' ? 'selected' : '' ?>>Renda</option>
            </select>
            <button type="submit" name="acao" value="buscar">Buscar</button>
            <?php if ($busca !== ''): ?>
                <button class="btn-clean"> <a href="cliente.php">Limpar</a></button>
            <?php endif; ?>
        </form>

        <!--trecho de exibição dos clientes-->
        <?php if (count($clientes) > 0): ?>
            <div class="product-grid">
                <?php foreach ($clientes as $cliente): ?>
                    <div class="product-card">
                        <h3><?= $cliente['nomeCliente'] ?></h3>
                        <p><strong>Email: </strong><?= $cliente['email'] ?></p>
                        <p><strong>Telefone: </strong><?= $cliente['telefone'] ?></p>
                        <p><strong>Estado Cívil: </strong><?= $cliente['estadoCivil'] ?></p>
                        <p><strong>Dependentes: </strong><?= $cliente['quantidadeDependentes'] ?></p>
                        <p><strong>Renda: </strong><?= number_format($cliente['renda'], 2, ",", ".") ?></p>
                        <div class="product-actions">
                            <a href="cliente_editar.php?id=<?= $cliente['id'] ?>" class="btn-edit">Editar</a>

<a href="cliente_excluir.php?id=<?= $cliente['id'] ?>"
   class="btn-delete"
   onclick="return confirm('Tem certeza que deseja excluir o produto?')">
   Excluir
</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Nenhum cliente cadastrado no Banco de Dados.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once "templates/footer.php"; ?>