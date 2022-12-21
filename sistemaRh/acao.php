
<?php
include_once ('config/conf.php');
//$_SERVER['DOCUMENT_ROOT'];
//var_dump(JSON); -MITO
$id = isset($_POST['id'])?$_POST['id']:0;  // teste ISSET é para verificar se os dados foram enviad
$nome = isset($_POST['nome'])?$_POST['nome']:'';
$sobrenome = isset($_POST['sobrenome'])?$_POST['sobrenome']:'';
$cargo = isset($_POST['cargo'])?$_POST['cargo']:'';
$salario = isset($_POST['salario'])?$_POST['salario']:'';
$dtnasc = isset($_POST['dtnasc'])?$_POST['dtnasc']:'';
$email = isset($_POST['email'])?$_POST['email']:'';
$telefone = isset($_POST['telefone'])?$_POST['telefone']:'';
$sexo = isset($_POST['sexo'])?$_POST['sexo']:'';
$pcd = isset($_POST['pcd'])?$_POST['pcd']:'';
$estado = isset($_POST['estado'])?$_POST['estado']:'';
$cidade = isset($_POST['cidade'])?$_POST['cidade']:'';
$dtcontratacao = isset($_POST['dtcontratacao'])?$_POST['dtcontratacao']:'';

// se a ação for excluir virá via GET
$acao =  isset($_GET['acao'])?$_GET['acao']:"";

if ($acao == 'excluir'){ // exclui um registro do banco de dados
    try{
        $id =  isset($_GET['id'])?$_GET['id']:0;  // se for exclusão o ID vem via GET
        
        // cria a conexão com o banco de dados 
        $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);
        $query = 'DELETE FROM funcionarios WHERE id = :id';
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id',$id);
        // executar a consulta
        if ($stmt->execute())
            header('location: index.php');
        else
            echo 'Erro ao excluir dados';
    }catch(PDOException $e){ // se ocorrer algum erro na execuçao da conexão com o banco executará o bloco abaixo
        print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
        die();
    }
}else{ // então é para inserir ou atualizar
    if ($nome != "" && $email != ""){
        // salvar no banco de dados    
        try{
            // cria a conexão com o banco de dados 
            $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);
            // montar consulta
            if ($id > 0) // se o ID está informado é atualização
                $query = 'UPDATE funcionarios 
                             SET nome = :nome, sobrenome = :sobrenome, cargo = :cargo, salario = :salario,dtnasc = :dtnasc,
                             email = :email, telefone = :telefone, sexo = :sexo, pcd = :pcd, 
                             estado = :estado, cidade = :cidade, dtcontratacao = :dtcontratacao
                           WHERE id = :id';
            else // senão será inserido um novo registro
                $query = 'INSERT INTO funcionarios (
                nome,
                sobrenome,
                cargo,
                salario,
                dtnasc,
                email,
                telefone,
                sexo,
                pcd,
                estado,
                cidade,
                dtcontratacao
                ) 
                VALUES (:nome,
                :sobrenome,
                :cargo,
                :salario,
                :dtnasc,
                :email,
                :telefone,
                :sexo,
                :pcd,
                :estado,
                :cidade,
                :dtcontratacao
                )';
            // preparar consulta
            $stmt = $conexao->prepare($query);
            // vincular variaveis com a consulta
            $stmt->bindValue(':nome',$nome);   
            $stmt->bindValue(':sobrenome',$sobrenome);
            $stmt->bindValue(':cargo',$cargo);
            $stmt->bindValue(':salario',$salario);
            $stmt->bindValue(':dtnasc',$dtnasc);       
            $stmt->bindValue(':email',$email);
            $stmt->bindValue(':telefone',$telefone);         
            $stmt->bindValue(':sexo',$sexo);
            $stmt->bindValue(':pcd',$pcd);
            $stmt->bindValue(':estado',$estado); 
            $stmt->bindValue(':cidade',$cidade);  
            $stmt->bindValue(':dtcontratacao',$dtcontratacao);
            if ($id > 0) // atualização
                $stmt->bindValue(':id',$id);

            // executar a consulta
            if ($stmt->execute())
                header('location: index.php?usr='.$conexao->lastInsertId());
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
