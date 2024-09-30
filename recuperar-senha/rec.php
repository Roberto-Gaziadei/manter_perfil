<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "../conecta.php";
$conexao = conectar();

$email = $_POST['email'];
$sql = "SELECT * FROM usuario WHERE email='$email'";
$result = executarSQL($conexao, $sql);
$usuario = mysqli_fetch_assoc($result);

if ($usuario == null) {
    echo "Email não cadastrado! Faça o cadastro e 
          em seguida realize o login. <a href='../index.php'>Volte para a tela inicial</a>";
    die();
}

$token = bin2hex(random_bytes(50));

require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';
include '../config.php';

$mail = new PHPMailer(true);

try {
    // configurações
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->setLanguage('br');
    //$mail->SMTPDebug = SMTP::DEBUG_OFF;  //tira as mensagens de erro
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //imprime as mensagens de erro
    $mail->isSMTP();                       //envia o email usando SMTP
    $mail->Host = 'smtp.gmail.com';       
    $mail->SMTPAuth = true;               
    $mail->Username = $config['email'];  
    $mail->Password = $config['senha_email']; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    /* TCP port to connect to; use 587 if you have set 
    `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` */
    $mail->Port = 587;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $mail->setFrom($config['email'], 'Recuperar sua conta');
    $mail->addAddress($usuario['email'], $usuario['nome']);  
    $mail->addReplyTo($config['email'], 'Recuperar sua conta');

    $mail->isHTML(true);       
    $mail->Subject = 'Recuperação de Senha do Sistema';
    $mail->Body = 'Olá!<br>
        Você solicitou a recuperação da sua conta no nosso sistema.
        Para isso, clique no link abaixo para realizar a troca de senha:<br>
        <a href="' . $_SERVER['SERVER_NAME'] . '/atividade-Thiago/recuperar-senha/nova-senha?email=' . $usuario['email'] .
        '&token=' . $token . 
        '">Clique aqui para recuperar o acesso à sua conta!</a><br>
        <br>
        Atenciosamente<br>
        Equipe do sistema...';

    $mail->send();
    echo 'Email enviado com sucesso!<br>Confira o seu email.' . '<br>';
    echo "<a href='../index.php'>Clique aqui para voltar para a pagina de login</a>";

    // Gravar as informações na tabela recuperar senha
    date_default_timezone_set('America/Sao_Paulo');
    $data = new DateTime('now');
    $agora = $data->format('Y-m-d H:i:s');


    $sql2 = "INSERT INTO `recuperar-senha`
            (email, token, data_criacao, usado) 
            VALUES ('". $usuario['email'] . "', '$token', 
            '$agora', 0)";
    executarSQL($conexao, $sql2);
} catch (Exception $e) {
    echo "Não foi possível enviar o email. 
          Mailer Error: {$mail->ErrorInfo}";
}