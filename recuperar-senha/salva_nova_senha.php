<?php

include_once "../conecta.php";
$conexao = conectar();

$email = $_POST['email'];
$token = $_POST['token'];
$senha = $_POST['senha'];
$repetirsenha = $_POST['repetirsenha'];

$sql = "SELECT * FROM `recuperar-senha` WHERE email='$email' AND token='$token'";
$result = executarSQL($conexao, $sql);
$recup = mysqli_fetch_assoc($result);

if ($result == null){
    echo "Email ou token incorretos. Tente fazer um novo pedido
    de recuperação de senha. <a href='form-rec-senha.php'>Volte para recuperação de senha</a>";
    die();
} else {

    date_default_timezone_set('America/Sao_Paulo');
    $data = new DateTime('now');
    $data_criacao = DateTime::createFromFormat(
        'Y-m-d H:i:s',
        $recup['data_criacao']
    );
    $UmDia = DateInterval::createFromDateString(('1 day'));
    $dataExpiracao = date_add($data_criacao, $UmDia);

    if ($data > $dataExpiracao) {
        echo "Essa solicitação de recuperação de senha expirou!
        Faça um novo pedido de recuperação de senha.
        <a href='form-rec-senha.php'>Volte para recuperação de senha</a>";
        die();
    }

    if($recup['usado'] == 1){
        echo "Esse pedido de recuperação ja foi utilizado!
        Para recuperar a conta faça um novo pedido
        <a href='form-rec-senha.php'>Volte para recuperação de senha</a>";
        die();
    }

    if($senha != $repetirsenha){
        echo "A senha que você digitou é diferente de senha
        que você digitou no repetir senha. Por favor tente novamente. <a href='nova-senha.php'>Volte para a pagina anterior</a>";
    }

    $sql2 = "UPDATE usuario SET senha='$senha' WHERE
    email='$email'";
    executarSQL($conexao, $sql2);
    $sql3 = "UPDATE `recuperar-senha` SET usado=1
    WHERE email='$email' AND token='$token'";
    executarSQL($conexao,$sql3);

    echo "Nova senha cadastrada com sucesso! Faça o login
    para acessar o sistema.<br>";
    echo "<a href='../index.php'>Acessar o sistema</a>";
}

?>