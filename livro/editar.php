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
        
        <form action="/gerenciamento_livros/livro/salvar_edicao.php" method="post">
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
        <button type="submit">Salvar Alterações</button>
        </form>

        <a class="cancelar-btn" href="./mostrar_livros.php">Cancelar</a>


    </div>
</body>
</html>