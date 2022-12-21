<?php
include_once ('../config/conf.php');
//var_dump(JSON); -MITO
$id = isset($_POST['id'])?$_POST['id']:0;  // teste ISSET é para verificar se os dados foram enviad
$titulo = isset($_POST['titulo'])?$_POST['titulo']:'';
$requisitos = isset($_POST['requisitos'])?$_POST['requisitos']:'';
$salario = isset($_POST['salario'])?$_POST['salario']:'';
$descricao = isset($_POST['descricao'])?$_POST['descricao']:'';

// se a ação for excluir virá via GET
$acao =  isset($_GET['acao'])?$_GET['acao']:"";

if ($acao == 'excluir'){ // exclui um registro do banco de dados
    try{
        $id =  isset($_GET['id'])?$_GET['id']:0;  // se for exclusão o ID vem via GET
        
        // cria a conexão com o banco de dados 
        $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);
        $query = 'DELETE FROM vaga WHERE id = :id';
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id',$id);
        // executar a consulta
        if ($stmt->execute())
            header('location: viewVagas.php');
        else
            echo 'Erro ao excluir dados';
    }catch(PDOException $e){ // se ocorrer algum erro na execuçao da conexão com o banco executará o bloco abaixo
        print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
        die();
    }
}else{ // então é para inserir ou atualizar
    if ($titulo!="" && $salario != ""){
        echo("outro aqui");
        // salvar no banco de dados    
        try{
            // cria a conexão com o banco de dados 
            $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);
            // montar consulta
            if ($id > 0){ // se o ID está informado é atualização
                
                $query = 'UPDATE vaga 
                             SET titulo = :titulo,
                                requisitos = :requisitos,
                                salario = :salario,
                                descricao = :descricao
                           WHERE id = :id';
            }else{ // senão será inserido um novo registro
                $query = 'INSERT INTO vaga (
                titulo,
                requisitos,
                salario,
                descricao
                ) 
                VALUES (
                :titulo,
                :requisitos,
                :salario,
                :descricao
                )';}
            // preparar consulta
            $stmt = $conexao->prepare($query);
            // vincular variaveis com a consulta
            $stmt->bindValue(':titulo',$titulo);   
            $stmt->bindValue(':requisitos',$requisitos);
            $stmt->bindValue(':salario',$salario);
            $stmt->bindValue(':descricao',$descricao);
            if ($id > 0) // atualização
                $stmt->bindValue(':id',$id);

            // executar a consulta
            if ($stmt->execute())
                header('location: vagas.php');
            else
                echo 'Erro ao inserir/editar dados';
        }catch(PDOException $e){ // se ocorrer algum erro na execuçao da conexão com o banco executará o bloco abaixo
            print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
            die();
        }catch(Exception $e){ // se ocorrer algum erro na execuçao da conexão com o banco executará o bloco abaixo
            print("Erro genérico...<br>".$e->getMessage());
            die();
        }
    }
}

?> 
