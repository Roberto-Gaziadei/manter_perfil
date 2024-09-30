<?php

//conectar com o banco de dados.
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

//receber os dados.
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$icone = $_POST['icone'];

//verificar se o email já está cadastrado no sistema.
$consulta_usuario = executarSQL($mysql, "SELECT COUNT(*) FROM usuario WHERE email = '$email'");
$quantidade_usuario = mysqli_fetch_row($consulta_usuario)[0];

if ($quantidade_usuario == 0) {

    $sql = "INSERT INTO usuario (nome,email,senha,foto_perfil)
    VALUES ('$nome', '$email', '$senha','$icone')";

    executarSQL($mysql, $sql);

    header("location:../index.php");
    
} else {

    echo "O email já existe no banco de dados!<p><a href = \"formcadUsuario\">Voltar</a></p>";
}
