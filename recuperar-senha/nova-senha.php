<?php

$email = $_GET['email'];
$token = $_GET['token'];

include_once "../conecta.php";
$conexao = conectar();

$sql = "SELECT * FROM `recuperar-senha` WHERE email='$email' AND token='$token'";
$result = executarSQL($conexao, $sql);
$recup = mysqli_fetch_assoc($result);

if($recup == null){
    echo "Email ou token incorretos. Tente fazer outro pedido
    de recuperação de senha. <a href='form-rec-senha.php'>Volte para a pagina de recuperação de senha</a>";
    die();
} else {
    date_default_timezone_set('America/Sao_Paulo');
    $data = new DateTime('now');
    $data_criacao = DateTime::createFromFormat(
        'Y-m-d H:i:s', $recup['data_criacao']
    );
    $umdia = DateInterval::createFromDateString((' 1day'));
    $dataexpiracao = date_add($data_criacao, $umdia);

    if($data > $dataexpiracao){
        echo "Essa solicitação expirou!
        Realize um novo pedido de recuperação de senha. <a href='form-rec-senha.php'>Volte para a pagina de recuperação de senha</a>";
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova senha</title>
</head>
<body>
    <form action="salva_nova_senha.php" method="post">
        <input type="hidden" name="email" value="<?= $email ?>"/>
        <input type="hidden" name="token" value="<?= $token ?>"/>
        Email: <?= $email ?> <br><br>
        <label> Senha: <input type="password" name="senha"> </label> <br><br>
        <label> Repita sua senha: <input type="password" name="repetirsenha"> </label> <br><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>