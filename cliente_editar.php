<?php
$titulopagina = "Pbe1 ComerciOS - Cliente Editar";
require_once "templates/header.php";

if (!isset($_SESSION['usuariologado'])) {
    header('Location: login.php');
    exit;
}



//trecho para atualizar (Uploud)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nomeCliente'], $_POST['email'], $_POST['telefone'], $_POST['estadoCivil'], $_POST['quantidadeDependentes'], $_POST['renda'], $_POST['acao'])) {
        $id = $_POST['id'];
        $nomeCliente = $_POST['nomeCliente'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $estadoCivil = $_POST['estadoCivil'];
        $quantidadeDependentes = (int)$_POST['quantidadeDependentes'];
        $renda = (float)$_POST['renda'];
        $acao = $_POST['acao'];

        if ($acao == 'salvar') {
            $conexao = conectar();
            $sql = "UPDATE cliente SET nomeCliente = ?, email = ?, telefone = ?, estadoCivil = ?, quantidadeDependentes = ?, renda  = ? WHERE id = ?";
            $stmt = mysqli_prepare($conexao, $sql);
            mysqli_stmt_bind_param($stmt, "ssssidi", $nomeCliente, $email, $telefone, $estadoCivil, $quantidadeDependentes, $renda, $id);
            mysqli_stmt_execute($stmt);
            mysqli_close($conexao);
            header("Location: cliente.php");
            exit;
        }
    }
}

$cliente = null;
$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id > 0) {
    $conexao = conectar();
    $sql = "SELECT * FROM cliente WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $cliente = mysqli_fetch_assoc(($resultado));
    mysqli_close($conexao);
}
if (!$cliente) {
    header('Location: cliente.php');
    exit;
}

?>
<div class="page-layout-produto">
    <div class="form-container">
        <h1>Edição de Clientes</h1>
        <form action="cliente_editar.php" method="post">
            <input type="hidden" name="id" value="<?= $cliente['id']; ?>">    
            <label for="nomeCliente">Nome do Cliente: </label>
            <input type="text" name="nomeCliente" id="nomeCliente" value="<?= $cliente['nomeCliente']; ?>" required>
            <label for="email">Email: </label>
            <input type="text" name="email" id="email" value="<?= $cliente['email']; ?>" required>
            <label for="preco">Telefone: </label>
            <input type="number" name="telefone" id="telefone" value="<?= $cliente['telefone']; ?>" required>
            <label for="quantidade">Estado Civil: </label>
            <input type="text" name="estadoCivil" id="estadoCivil" value="<?= $cliente['estadoCivil']; ?>" required>
            <label for="quantidade">Quantidade de Dependentes: </label>
            <input type="number" name="quantidadeDependentes" id="quantidadeDependentes" value="<?= $cliente['quantidadeDependentes']; ?>" required>
            <label for="renda">Renda: </label>
            <input type="number" name="renda" id="renda" value="<?= $cliente['renda']; ?>" required>     
            <button type="submit" name="acao" value="salvar">Salvar</button>
        </form>
    </div>
</div>
<?php require_once "templates/footer.php";  ?>