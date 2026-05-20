<?php

$titulopagina = "Pbe1 ComerciOS - Home";

require_once "templates/header.php";

$mensagemerro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['acao'], $_POST['usuario'], $_POST['senha'])) {

        $acao = $_POST['acao'];
        $usuario = trim($_POST['usuario']);
        $senha = trim($_POST['senha']);

        if ($acao == 'acessar') {

            if (!empty($usuario) && !empty($senha)) {

                $conexao = conectar();

                $sql = "SELECT * FROM usuario WHERE nomeUsuario = ?";

                $stmt = mysqli_prepare($conexao, $sql);

                mysqli_stmt_bind_param($stmt, "s", $usuario);

                mysqli_stmt_execute($stmt);

                $resultado = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($resultado) > 0) {

                    $usuarioConsultado = mysqli_fetch_assoc($resultado);

                    // Comparação da senha
                    if ($usuarioConsultado['senhaUsuario'] == $senha) {

                        $_SESSION['usuariologado'] = $usuario;

                        header("Location: home.php");
                        exit;

                    } else {

                        $mensagemerro = "Usuário ou senha incorretos.";
                    }

                } else {

                    $mensagemerro = "Usuário ou senha incorretos.";
                }

                mysqli_close($conexao);

            } else {

                $mensagemerro = "Preencha usuário e senha.";
            }
        }
    }
}

?>

<div class="container">

    <h1>Acessar o sistema</h1>

    <form action="login.php" method="post">

        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" id="usuario">

        <br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha">

        <br><br>

        <button type="submit" name="acao" value="acessar">
            Entrar
        </button>

    </form>

</div>

<div>
    <p><?php echo $mensagemerro; ?></p>
</div>

<?php require_once "templates/footer.php"; ?>