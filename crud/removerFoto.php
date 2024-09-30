<?php

//conectar no banco de dados.
require_once "../conecta.php";

//variavel de conexao.
$mysql = conectar();

$pasta = "../foto/";

$nome = $_GET['nome'];

if ($nome == "user.png") {

    header("location:../inicial.php");

}else {
    
    $sql = "UPDATE usuario SET foto_perfil = 'user.png'";

    executarSQL($mysql, $sql);

    unlink($pasta.$nome);

    header("location:../inicial.php");

}