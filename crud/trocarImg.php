<?php

//iniciar a session.
session_start();

session_regenerate_id(true);

if (!isset($_SESSION['usuario'][1])) {
   
    header("location:../index.php");

    die ();
}

//conectar no banco dados.
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

$sql = "SELECT user.foto_perfil FROM usuario user WHERE id_usuario = " . $_SESSION['usuario'][1];

$result = executarSQL($mysql, $sql);

$dados = mysqli_fetch_assoc($result);

$pasta = "../foto/";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar imagem de perfil</title>

    <style>
        .div2 {
            border-radius: 10px;
            position: absolute;
            height: 10%;
            width: 5%;
            border: 1px black solid;
            top: 70px;
            left: 30px;
        }

        img {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .form{
            top: 20%;
            position: absolute;
        }
        .a{
            position: absolute;
            top: 35%;
        }
    </style>

</head>

<body>

<h1>Configurações da sua foto de perfil.</h1>


    <div class="div2">
        <img src="<?php echo $pasta . $dados['foto_perfil']; ?>" alt="foto de perfil do usuario.">
    </div>

    <?php

    if ($dados['foto_perfil'] == "user.png") {

        echo '<form class="form" enctype="multipart/form-data" action = "alterarFoto.php" method = "post" >';

        echo '<label for="img">Escolha a sua foto de perfil: </label>';

        echo '<input type="file" name="foto">' . '<br><br>';

        echo '<input type = "submit" value = "Alterar foto de perfil">' . '<br><br>';

        echo '<button><a href = "removerFoto.php?nome='.$dados['foto_perfil'].'     ">Remover foto de perfil</a></button>';

        echo '</form>';
        
    }else {
        
        echo '<form class="form" enctype="multipart/form-data" action = "alterarFoto.php" method = "post" >';

        echo '<label for="img">Escolha a sua foto de perfil: </label>';

        echo '<input type="file" name="foto">' . '<br><br>';

        echo '<input type = "hidden" value = "'.$dados['foto_perfil'].'" name="fotoPerfi">';

        echo '<input type = "submit" value = "Alterar foto de perfil">' . '<br><br>';

        echo '<button><a href = "removerFoto.php?nome='.$dados['foto_perfil'].'">Remover foto de perfil</a></button>';

        echo '</form>';
    }
    
    ?>

    <a class="a" href="../inicial.php">Voltar</a>
</body>

</html>