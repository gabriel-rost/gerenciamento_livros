<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editando usuário</title>
    <link rel="stylesheet" href="./styles/formulario.css">
</head>
<body>
        <?php

            require_once("./../utils/nav.php");

            echo "<div class='container'>";

            $id_livro = isset($_GET["id"]) ? (int) $_GET["id"] : 0; // pegando o parametro de usuário que vem da url e faz a conversão para int

            // abrindo uma conexão de banco de dados usando o mysqli
            $conn = new mysqli("localhost", "root", "", "vbooks");

            // testa se conectou com o banco de dados
            if ($conn->connect_error) {
                die ("Houve um erro ao conectar com o banco de dados");
            }            

            // string da consulta responsável por recuperar o registro a ser editado
            // o ? será o parametro que será inserido na consulta
            $sql = "SELECT * FROM livros WHERE id = ?";

            // definindo e preparando a consulta parametrizada
            $stmt = $conn->prepare($sql);    

            // definindo os paramatros da consulta (cada ?) 
            // i - int
            // f - float
            // s - string
            $stmt->bind_param("i", $id_livro); 

            $stmt->execute();    // executando a consulta

            $resultado = $stmt->get_result();   // armazenando o resultado da consulta no result set

            //testando quantas linhas o result set retornou
            if ($resultado->num_rows == 1) {
                // encontrou o registro 
                $usuario = $resultado->fetch_assoc();

                $titulo = $usuario["titulo"];
                $autor = $usuario["autor"];
                $genero_id = $usuario["genero_id"];
                $editora = $usuario["editora"];
                $ano_publicacao = $usuario["ano_publicacao"];
                $classificacao = $usuario["classificacao"];

            } else {
                // não encontrou nenhum registro
                header("location: ./mostrar_livros.php");
            }
            
            $stmt->close(); // encerra a consulta
            $conn->close(); // fecha a conexão com o banco de dados
        ?>

        <!-- criando um campo oculto de formulário para controlar se a operação é de edição -->
        
        <form action="" method="post">
        <label for="titulo">
            Título:
        </label>
        <input type="text" name="titulo" id="titulo" value="<?= $titulo ?>">
        <label for="autor">
            Autor:
        </label>
        <input type="text" name="autor" id="autor" value="<?= $autor ?>">
        <label for="genero">
            Gênero:
        </label>
        <select name="genero" id="genero">

        <?php
        $conn = mysqli_connect("localhost", "root", "", "vbooks");

        if (!$conn) {
            die("Houve um erro ao conectar com o banco de dados");
        }

        // valor selecionado, vindo do formulário ou de outro lugar
        $genero_id = isset($genero_id) ? $genero_id : null;

        $sql = "SELECT id, nome FROM generos ORDER BY nome ASC";
        $resultSet = mysqli_query($conn, $sql); 

        if (mysqli_num_rows($resultSet) > 0) {
            while ($row = mysqli_fetch_assoc($resultSet)) {
                $selected = ($row['id'] == $genero_id) ? 'selected' : '';
                echo '<option value="' . htmlspecialchars($row['id']) . '" ' . $selected . '>' . htmlspecialchars($row['nome']) . '</option>';
            }
        } else {
            echo '<option value="">Nenhum gênero encontrado</option>';
        }

        mysqli_close($conn); 
        ?>

        </select>
        <label for="editora">
            Editora:
        </label>
        <input type="text" id="editora" name="editora" value=" <?= $editora ?> ">
        <label for="ano">
            Ano:
        </label>
        <input type="number" id="ano" name="ano" value="<?= (int)$ano_publicacao ?>">

        <div class="classificacao-group">
            <label>
                Classificação Indicativa
            </label>
        <p>Insira a classificaçã indicativa:</p>
          <input type="radio" id="criancas" name="classificacao" value="Crianças" <?= $classificacao == "Crianças" ? 'checked' : '' ?>>
            <label for="criancas">Crianças</label><br>
          <input type="radio" id="todas_idades" name="classificacao" value="Todas as idades" <?= $classificacao == "Todas as idades" ? 'checked' : '' ?>>
            <label for="todas_idades">Todas as idades</label><br>
          <input type="radio" id="adulto" name="classificacao" value="Adulto" <?= $classificacao == "Adulto" ? 'checked' : '' ?>>
            <label for="adulto">Adulto</label>
        </div>
        <!-- criando um campo oculto de formulário para controlar se a operação é de edição -->
        <input type="hidden" name="id_livro" value="<?=  $id_livro ?>">
        <button type="submit">Cadastrar</button>
        </form>

        <a class="cancelar-btn" href="./mostrar_livros.php">Cancelar</a>


    </div>
</body>
</html>


<?php
    require_once("./../db/db_config.php");
    //require_once("./../../utils/protege.php");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Conectar ao banco de dados
        $conn = new mysqli($db_host, $db_user, $db_password, $db_name, $db_port);

        // Verificar conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Obter dados do formulário
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $genero_id = $_POST['genero'];
        $editora = $_POST['editora'];
        $ano = $_POST['ano'];
        $classificacao = $_POST['classificacao'];

        if ($conn){

            $id = $_POST["id_livro"]; // recuperando o campo oculto do formulário

            // se existe o parametro id_usuario no form é por que é uma operação de edição
            if (isset($id) && !empty($id))
                // consulta sql que atualiza o registro
                echo $sql = "UPDATE livros SET titulo = '$titulo', autor = '$autor', genero_id = '$genero_id', editora = '$editora', ano_publicacao = '$ano', classificacao = '$classificacao' WHERE id = $id";

            // manda executar a consulta e testa se ela retornou true, indicando que houve sucesso
            // se retornar false, indica que houve erro na consulta
            if (mysqli_query($conn, $sql) ) {
                // para mostrar a mensagem de sucesso, será necessário uma variavel de sessão
                session_start();	// iniciando a sessão
                
                if (isset($id) && !empty($id))
                    $_SESSION["msg_sucesso"] = "Usuário atualizado com sucesso"; // armazena a mensagem de sucesso na variavel de sessão
                else
                    $_SESSION["msg_sucesso"] = "Usuário inserido com sucesso"; // armazena a mensagem de sucesso na variavel de sessão

                header("location: ../mostrar_livros.php");	// faz um redirecionamento para outra página
                
                mysqli_close($conn);	// fecha a conexão com o banco de dados
            } else {
                echo ("Houve um erro ao tentar inserir <br> " . mysqli_error($conn) );
            }

        } else {
            die("Houve um erro ao conectar com o banco de dados");
        }
    }

?>