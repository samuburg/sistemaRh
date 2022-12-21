<?php
include "config/conf.php";
try{
    $conexao =  new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);
}catch(PDOException $e){ // se ocorrer algum erro na execuçao da conexão com o banco executará o bloco abaixo
        print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
        die();
}catch(Exception $e){ // se ocorrer algum erro na execuçao da conexão com o banco executará o bloco abaixo
        print("Erro genérico...<br>".$e->getMessage());
        die();
}


$user = isset($_POST['user'])?$_POST['user']:"";
$senha = isset($_POST['senha'])?$_POST['senha']:"";
try{
    if ($user != "" && $senha != ""){
        $query = 'select CAST(AES_DECRYPT(senha,"chave") as char) from usuario WHERE nome = "'.$user.'";';
        $stmt = $conexao->prepare($query);
        $stmt->execute();
        $usuario = $stmt->fetch();
        $verifica = $usuario;
        
    }
 } catch(PDOException $e){ // se ocorrer algum erro na execuçao da conexão com o banco executará o bloco abaixo
    //print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
        die();
    }
    if ($verifica==$senha){
        echo '<script>alert("bem vindo!")</script>';
        header('location: index.php');
        
    }else {
        echo 'Usuario e/ou senha incorreto, volte e tente novamente ';
    }
    


?>