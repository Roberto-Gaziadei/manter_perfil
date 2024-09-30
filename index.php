<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de login</title>

</head>

<body>
    <style>
        body{
            background-color: #a0aab4;
        text-align: center;
        position: relative;
        top: 50%;
        transform: translateY(250px);
        
    }
    </style>

    <h1>Tela de login</h1>

    <form action="login.php" method="post">
        <label for="email">Digite seu email:</label>
        <input type="email" name="email" id="email" placeholder="Digite seu email"><br><br>

        <label for="senha">Digite sua senha:</label>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha"><br><br>

        <input type="submit" value="Logar"><br>

        <p><a href="recuperar-senha/form-rec-senha.php">Recuperar senha</a></p>
        <p><a href="crud/formcadUsuario.html">Registre-se</a></p>
    </form>

</body>

</html>