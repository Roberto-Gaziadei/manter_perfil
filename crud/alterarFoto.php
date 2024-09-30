<?php

//conectar no banco de dados.
require_once "../conecta.php";

$mysql = conectar();

//iniciar a session.
session_start();


session_regenerate_id(true);

if (!isset($_SESSION['usuario'][1])) {
   
    header("location:../index.php");

    die ();
}

//receber a foto.
$foto = $_FILES['foto'];

if ($foto['size'] == 0) {

    header("location: trocarImg.php");
    
}

//verificar se deu erro no recebimento do arquivo.
if ($foto['error'] != 0) {

    die("Falha ao receber a foto de perfil! <p><a href = \"trocarImg.php\">Tentar de novo?</a></p>");
} else {

    //pasta de destino.
    $pastaDestino = "../foto/";

    //nome do arquivo.
    $nome_foto = $foto['name'];

    //novo nome do arquivo.
    $novo_nome_foto = uniqid();

    //estenção do certificado.
    $extencao = strtolower(pathinfo($nome_foto, PATHINFO_EXTENSION));

    //verificar as extenções que são permitidas.
    if (
        $extencao != "png" and $extencao != "jpeg" and

        $extencao != "gif" and $extencao != "jfif" and

        $extencao != "svg"  and $extencao != "jpg"

    ) {

        echo "Este tipo de arquivos" . " " . "|" . "." . $extencao . "|" . " " . "não é aceito <p><a href = \"trocarImg.php\">Voltar</a></p>";
    } else {

        //mover o arquivo.
        $mover_foto = move_uploaded_file($foto['tmp_name'], $pastaDestino . $novo_nome_foto . "." . $extencao);

        //verificar se deu certo mover certificado.
        if ($mover_foto) {

            //criar o caminho.
            $caminho = $novo_nome_foto . "." . $extencao;

            //inserir no banco de dados.
            $sql = "UPDATE usuario SET foto_perfil = '$caminho' WHERE id_usuario = " . $_SESSION['usuario'][1];


            $query = mysqli_query($mysql, $sql);

            if (isset($_POST['fotoPerfi'])) {

                unlink($pastaDestino . $_POST['fotoPerfi']);

                header("location: trocarImg.php");
            } else {

                header("location: trocarImg.php");
            }
        }
    }
}
