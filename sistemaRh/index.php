<?php

include_once "acao.php";

  // pega variáveis enviadas via GET - são enviadas para edição de um registro
$acao = isset($_GET['acao'])?$_GET['acao']:"";
$id = isset($_GET['id'])?$_GET['id']:0;
// verifica se está editando um registro
if ($acao == 'editar'){
    // buscar dados do usuário que estamos editando
    try{
        // cria a conexão com o banco de dados 
        $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);
        // montar consulta
        $query = 'SELECT * FROM funcionarios WHERE id = :id' ;
        // preparar consulta
        $stmt = $conexao->prepare($query);
        // vincular variaveis com a consult
        $stmt->bindValue(':id',$id); 
        // executa a consulta
        $stmt->execute();
        // pega o resultado da consulta - nesse caso a consulta retorna somente um registro pq estamos buscando pelo ID que é único 
        // por isso basta um fetch
        $usuario = $stmt->fetch(); 
    }catch(PDOException $e){ // se ocorrer algum erro na execuçao da conexão com o banco executará o bloco abaixo
        print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
        die();
    }  
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- CSS only -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="estilo.css">
    <title>Relação de Funcionários</title>
    <script>

        // floreio -- para o usuário confirmar a exclusão
        function excluir(url){
            if (confirm("Confirma a exclusão?"))
                window.location.href = url; //redireciona para o arquivo que irá efetuar a exclusão
        }
    </script>
    
</head>
<body class='container'>
    <h1>Master Gestão de RH</h1>
    <nav class="navbar navbar-expand-lg navbar-light bg-light"> <!-- menu -->
        <ul class="menu">
            <li id="cadastrar" class="navbar-brand"><a href="novo/">Cadastrar Funcionário</a></li>
            <li id="vagas" class="navbar-brand"><a href="vagas/vagas.php">Nova Vaga de Emprego</a></li>
            <li id="viewVagas" class="navbar-brand"><a href="vagas/viewVagas.php">Visualizar Vagas Cadastradas</a></li>
            <li id="funcionarioIndex" class="navbar-brand"><a href="index.php">Visualizar Funcionarios</a></li>
            <li id="cadUsuario" class="navbar-brand"><a href="usuario/cadUsuario.php">Usuários</a></li>
        </ul>
    </nav>
    <h2>Funcionários da Empresa</h2>
    <section> <!-- pesquisa -->
        <div class='row'>
            <div class='col'>
                <form action="" id='pesquisa'>
                    <div class='row'>
                        <div class='col-6'></div>
                        <div class='col-4'>
                            <input class='form-control' type="search" name='busca' id='busca'>
                        </div>
                        <div class='col-2'>
                            <button class='btn btn-primary' type="submit">Filtrar</button>
                        </div>
                    </div>
                </form>            
            </div>
        </div>
    </section>
    <br>
    <section> <!-- tabela de funcionarios-->
        <div class="table-responsive-md">
            <div class="table-responsive-md" id='listagem'>
                <table class="table" id='lista'>
                <thead>
                    <tr>
                        <th>Id</th><th>Cargo</th><th>Nome</th><th>Salário</th><th>Alterar</th><th>Excluir</th>
                    </tr>
                </thead>
                <?php             
                        try{
                            // cria  a conexão com o banco de dados 
                            $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);
                            // pega o valor informado pelo usuário no formulário de pesquisa
                            $busca = isset($_GET['busca'])?$_GET['busca']:"";
                            // monta consulta
                            $query = 'SELECT * FROM funcionarios';
                            if ($busca != ""){ // se o usuário informou uma pesquisa
                                $busca = '%'.$busca.'%'; // concatena o curiga * na pesquisa
                                $query .= ' WHERE nome like :busca' ; // acrescenta a clausula where
                            }
                            // prepara consulta
                            $stmt = $conexao->prepare($query);
                             // vincular variaveis com a consulta
                            if ($busca != "") // somente se o usuário informou uma busca
                                $stmt->bindValue(':busca',$busca);
                            // executa a consuta 
                            $stmt->execute();
                            // pega todos os registros retornados pelo banco
                            $usuarios = $stmt->fetchAll();
                            foreach($usuarios as $usuario){ // percorre o array com todos os usuários imprimindo as linhas da tabela
                                $editar = '<a href=novo/index.php?acao=editar&id='.$usuario['id'].'>Alt</a>';
                                $excluir = "<a href='#' onclick=excluir('acao.php?acao=excluir&id={$usuario['id']}')>Excluir</a>";
                                echo '<tr><td>'.$usuario['id'].'</td><td>'.$usuario['cargo'].'</td><td>'.$usuario['nome'].'</td><td>'.$usuario['salario'].'</td><td>'.$editar.'</td><td>'.$excluir.'</td></tr>';
                            }
                        }catch(PDOException $e){ // se ocorrer algum erro na execuçao da conexão com o banco executará o bloco abaixo
                            print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
                            die();
                        }           
                    ?>  
                </table>
            </div>
        </div>
       
    </section>
</body>
</html>

