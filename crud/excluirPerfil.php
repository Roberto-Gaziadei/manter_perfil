<?php

//iniciar a sesssion.
session_start();

//conectar com bd.
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

$pasta = "../foto/";

$sql = "SELECT u.foto_perfil FROM usuario u WHERE id_usuario = " . $_SESSION['usuario'][1];

$query = executarSQL($mysql, $sql);

$foto = mysqli_fetch_assoc($query);

if ($foto['foto_perfil'] == "user.png") {

    $sql2 = "DELETE FROM usuario WHERE id_usuario = " . $_SESSION['usuario'][1];

    executarSQL($mysql, $sql2);

    header("location: ../logout.php");
} else {

    $sql3 = "DELETE FROM usuario WHERE id_usuario = " . $_SESSION['usuario'][1];

    executarSQL($mysql, $sql3);

    unlink($pasta . $foto['foto_perfil']);

    header("location: ../logout.php");
}
