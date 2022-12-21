<?php

include_once ('../config/conf.php');


  // pega variáveis enviadas via GET - são enviadas para edição de um registro
  $acao = isset($_GET['acao'])?$_GET['acao']:"";
  $id = isset($_GET['id'])?$_GET['id']:0;
  $usr = isset($_GET['usr'])?$_GET['usr']:0;
 /* if (3>2){
      echo(
      );
  }
  */
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
    <link rel="stylesheet" href="../estilo.css">
    <script src='../script.js'></script>
    <title>Cadastrar Novo Funcionário</title>

</head>
<body class='container'>
    <h1>Master Gestão de RH</h1>
    <nav class="navbar navbar-expand-lg navbar-light bg-light"> <!-- menu -->
        <ul class="menu">
            <li id="cadastrar" class="itemenu"><a href="index.php">Cadastrar Funcionário</a></li>
            <li id="vagas" class="itemenu"><a href="../vagas/vagas.php">Nova Vaga de Emprego</a></li>
            <li id="viewVagas" class="itemenu"><a href="../vagas/viewVagas.php">Visualizar Vagas Cadastradas</a></li>
            <li id="funcionarioIndex" class="itemenu"><a href="../index.php">Visualizar Funcionarios</a></li>
            <li id="cadUsuario" class="itemenu"><a href="../usuario/cadUsuario.php">Usuários</a></li>
        </ul>
    </nav>
    <h2>Dados do Funcionário</h2>
    <div class='row'>
        <div class='col'>
            <section id="formulario-cadastro">
                <form action="acao.php" id="ffuncionario" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div>
                            <label class="col-sm-2 col-form-label" for="nome"></label>
                            <input hidden class="form-control-plaintext" type="text" id="id" name="id"  value=<?php if(isset($usuario)) echo ($usuario['id']); else echo 0;?> >
                        </div>
                        <div>
                            <label class="form-label" for="nome">Nome:</label>
                            <input class="form-control" type="text" id="nome" name="nome" placeholder="Digite aqui seu nome..."  value= <?php if(isset($usuario)) echo $usuario['nome'] ?> >
                        </div>
                        <div>
                            <label class="form-label" for="sobrenome">Sobrenome:</label>
                            <input type="text"  class="form-control" id="sobrenome" name="sobrenome" placeholder="Digite aqui seu sobrenome..."  value=<?php if(isset($usuario)) echo $usuario['sobrenome'] ?>>
                        </div>
                        <div>
                            <label class="form-label" for="cargo">Cargo:</label>
                            <input type="text"  class="form-control" id="cargo" name="cargo" placeholder="Especifique o cargo..."  value=<?php if(isset($usuario)) echo $usuario['cargo'] ?>>
                        </div>
                        <div>
                            <label class="form-label" for="salario">Salário:</label>
                            <input type="number" step="0.01" class="form-control" id="salario" name="salario" placeholder="Salário do funcionário..."  value=<?php if(isset($usuario)) echo $usuario['salario'] ?>>
                        </div>
                        <div>
                            <label class="form-label" for="dtnasc">Data de Nascimento:</label>
                            <input type="date"  class="form-control" id="dtnasc" name="dtnasc" value=<?php if(isset($usuario)) echo $usuario['dtnasc'] ?>>
                        </div>
                        <div>
                            <label class="form-label" for="email">E-mail:</label>
                            <input type="email"  class="form-control"  id="email" name="email" value=<?php if(isset($usuario)) echo $usuario['email'] ?>>
                        </div>
                        <div>
                            <label class="form-label" for="telefone">Telefone:</label>
                            <input type="tel"  class="form-control"  id="telefone" name="telefone" value=<?php if(isset($usuario)) echo $usuario['telefone'] ?>>
                        </div>
                        <div>
                            <input type="radio"  class="form-check-input"   id="sexofeminino" name="sexo" value="1" <?php if((isset($usuario)) and $usuario['sexo']=='1') echo 'checked'; ?> >
                            <label class="form-check-label" for="sexofeminino">Feminino:</label>
                            <input type="radio" class="form-check-input"   id="sexomasculino" name="sexo" value="2" <?php if(isset($usuario) and $usuario['sexo']=='2') echo 'checked'; ?> >
                            <label class="form-check-label" for="sexomasculino">Masculino:</label>
                        </div>
                        <div>
                            <input type="checkbox" class="form-check-input"  id="pcd" name="pcd" <?php if(isset($usuario) and $usuario['pcd']) echo 'checked'?> > 
                            <label class="form-check-label"  for="pcd">Possui alguma deficiência?</label>
                        </div>
                        <div>
                            <label class="form-label" for="estado">Estado:</label>
                            <input type="estado"  class="form-control"  id="estado" name="estado" value=<?php if(isset($usuario)) echo $usuario['estado'] ?>>
                        </div>
                        <div>
                            <label class="form-label" for="email">Cidade:</label>
                            <input type="cidade"  class="form-control"  id="cidade" name="cidade" value=<?php if(isset($usuario)) echo $usuario['cidade'] ?>>
                        </div>
                        <div>
                            <label class="form-label" for="dtcontratacao">Data de Contratação:</label>
                            <input type="date"  class="form-control" id="dtcontratacao" name="dtcontratacao" value=<?php if(isset($usuario)) echo $usuario['dtcontratacao'] ?>>
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