<?php

function conectar(){

    $conexao = mysqli_connect(
        "localhost",
        "root",
        "",
        "pbe1comercios1a",
        3306
    );

    if (!$conexao){
        die("Erro ao conectar: " . mysqli_connect_error());
    }

    return $conexao;
}

?>