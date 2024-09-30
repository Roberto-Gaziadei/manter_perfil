<?php

//iniciar a session.
session_start();

//conectar com o banco de dados.
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

//receber os dados.
$nome = $_POST['nome'];
$email = $_POST['email'];

//verificar se o usuário não aletrou o seu email.
$sql = "SELECT user.email FROM usuario user WHERE id_usuario = " . $_SESSION['usuario'][1];

$query = executarSQL($mysql, $sql);

$userEmail = mysqli_fetch_array($query);

if ($userEmail['email'] == $email) {

    $sql1 = "UPDATE usuario SET nome = '$nome' WHERE id_usuario = " . $_SESSION['usuario'][1];

    executarSQL($mysql, $sql1);

    $_SESSION['usuario'][0] = $nome;

    header("location:../inicial.php");
} else {

    //verificar se o email existe no banco de dados.
    $consulta_usuario = executarSQL($mysql, "SELECT COUNT(*) FROM usuario WHERE email = '$email'");
    $quantidade_usuario = mysqli_fetch_row($consulta_usuario)[0];

    if ($quantidade_usuario != 0) {

        echo "O email já existe no sistema!";

        die();
        
    } else {

        $sql2 = "UPDATE usuario SET nome = '$nome', email = '$email' WHERE id_usuario = " . $_SESSION['usuario'][1];

        executarSQL($mysql, $sql2);

        $_SESSION['usuario'][0] = $nome;

        header("location:../inicial.php");
    }
}
