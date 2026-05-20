<?php

$conexao = mysqli_connect(
    "localhost",
    "root",
    "",
    "pbe1comercios1a",
    3306
);

if($conexao){
    echo "CONECTOU";
}else{
    echo mysqli_connect_error();
}