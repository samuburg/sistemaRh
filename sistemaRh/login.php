<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="meuicone.ico" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    
    <script src='js/script.js'></script>
    <title>LOGIN</title>
</head>
<body>
    <h1>MASTER GESTÃO DE RH</h1>
    <h1>Login</h1>
    <form action="acaoLogin.php" method="POST">
        <label for="user">Usuário:</label>
        <input type="text" name='user' id='user'>
        <label for="senha">Senha:</label>
        <input type="password" name='senha' id='senha'>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>