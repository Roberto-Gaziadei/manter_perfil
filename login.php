<?php

//iniciar a session.
session_start();

//conectar com o banco de dados.
require_once "conecta.php";

//veriavel de conexão.
$mysql = conectar();

//receber os dados.
$email = $_POST['email'];
$senha = $_POST['senha'];

//verificar se o email existe no banco de dados.
$consulta_usuario = executarSQL($mysql, "SELECT COUNT(*) FROM usuario WHERE email = '$email'");
$quantidade_usuario = mysqli_fetch_row($consulta_usuario)[0];

if ($quantidade_usuario == 0) {
    
    echo "Este usuário não está cadastrado no sistema. <p><a href=\"index.php\">Voltar</a></p>";

    die ();
}else {
    
    $sql = "SELECT * FROM usuario WHERE email = '$email'";
    $query = executarSQL($mysql, $sql);

    $usuario = mysqli_fetch_assoc($query);

    if ($senha == $usuario['senha']) {
    
        $_SESSION['usuario'][0] = $usuario['nome'];
        $_SESSION['usuario'][1] = $usuario['id_usuario'];

        header("location:inicial.php");

    }else {
        
        echo "Senha inválida<p><a href = \"index.php\">Voltar</a></p>";
    }
    
}