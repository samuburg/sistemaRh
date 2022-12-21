<?php

// parâmetros para a conexão
define ('DB_HOST','localhost');         // endereço do servidor de banco de dados
define ('DB_USER','root');            // root
define ('DB_PASSWORD','');           // ""
define ('DB_DB','rh');              // nome banco
define ('DB_PORT','3306');              // porta que o banco de dados recebe requisições
define ('MYSQL_DSN',"mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_DB.";charset=UTF8");


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
          $query = 'SELECT * FROM vaga WHERE id = :id' ;
          // preparar consulta
          $stmt = $conexao->prepare($query);
          // vincular variaveis com a consult
          $stmt->bindValue(':id',$id); 
          // executa a consulta
          $stmt->execute();
          // pega o resultado da consulta - nesse caso a consulta retorna somente um registro pq estamos buscando pelo ID que é único 
          // por isso basta um fetch
          $vaga = $stmt->fetch(); 
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
    <link rel="stylesheet" href="estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../estilo.css">
    <script src='script .js'></script>
    <title>Cadastrar Nova vaga de Emprego</title>

</head>
<body class='container'>
    <h1>Master Gestão de RH</h1>
    <nav class="navbar navbar-expand-lg navbar-light bg-light"> <!-- menu -->
        <ul class="menu">
            <li id="cadastrar" class="navbar-brand"><a href="../novo/">Cadastrar Funcionário</a></li>
            <li id="vagas" class="navbar-brand"><a href="vagas.php">Nova Vaga de Emprego</a></li>
            <li id="viewVagas" class="navbar-brand"><a href="viewVagas.php">Visualizar Vagas Cadastradas</a></li>
            <li id="funcionarioIndex" class="navbar-brand"><a href="../index.php">Visualizar Funcionarios</a></li>
            <li id="cadUsuario" class="navbar-brand"><a href="../usuario/cadUsuario.php">Usuários</a></li>
        </ul>
    </nav>
    <h1>Dados da Vaga</h1>
    <div class='row'>
        <div class="table-responsive-md">
            <section id="formulario-cadastro">
                <form action="acao.php" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div>
                            <label class="col-sm-2 col-form-label" for="nome"></label>
                            <input hidden class="form-control-plaintext" type="text" id="id" name="id"  value=<?php if(isset($vaga)) echo ($vaga['id']); else echo 0;?> >
                        </div>
                        <div>
                            <label class="form-label" for="titulo">Título da vaga:</label>
                            <input class="form-control" type="text" id="titulo" name="titulo" placeholder="Digite aqui o título da vaga..."  value= <?php if(isset($vaga)) echo $vaga['titulo'] ?> >
                        </div>
                        <div>
                            <label class="form-label" for="requisitos">Requisítos:</label>
                            <input class="form-control" type="text" id="requisitos" name="requisitos" placeholder="Digite aqui os requisitos..."  value= <?php if(isset($vaga)) echo $vaga['requisitos'] ?> >
                        </div>
                        <div>
                            <label class="form-label" for="salario">Salário aproximado:</label>
                            <input class="form-control" type="number" step="0.01" id="salario" name="salario" placeholder="salário aproximado para a vaga..."  value= <?php if(isset($vaga)) echo $vaga['salario'] ?> >
                        </div>
                        <div>
                            <textarea  class="form-control"  name="descricao" id="descricao" cols="30" rows="10" placeholder="Descrição das atividades da vaga..."><?=isset($vaga)?$vaga['descricao']:''?></textarea>
                        </div>
                        <div>
                            <button  class="btn btn-primary"  type="submit" name="acao" value="salvar">Salvar</button>
                            <input  class="btn btn-cancel"  type="reset" name="cancelar" value="Cancelar" onclick='window.location.href="index.php"'>
                        </div>
                    </fieldset>
                </form>
            </section>
        </div>
    </div>
</body>
</html>