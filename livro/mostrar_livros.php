<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./styles/cards.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exibir Livros</title>
</head>
<body>
    <?php require_once("./../utils/nav.php") ?>
    <div class="books">

    <?php 
        require_once("./../utils/protege.php");

        //session_start();    // para poder mostrar a mensagem de sessão
        if (isset($_SESSION["msg_sucesso"])) : 
    ?>    
        <div class="alert" id="alerta">
            <? echo "$_SESSION['msg_sucesso']" ?>
        </div>
    <?php 
        endif; 
        unset($_SESSION["msg_sucesso"]); 
    ?>

    <?php
        $conn = mysqli_connect("localhost", "root", "", "vbooks");

        // testa se a conexão ocorreu com sucesso
        if (!$conn){
            die("Houve um erro ao conectar com o banco de dados");
        }

        // gerar a string de consulta sql
        $sql = "SELECT id, titulo, autor, genero_id, editora, ano_publicacao, classificacao FROM livros ORDER BY titulo ASC";

        $resultSet = mysqli_query($conn, $sql); 

        if (mysqli_num_rows($resultSet) > 0) {

            // Recupera a próxima linha do resultado da consulta como um array associativo,
            while ($row = mysqli_fetch_assoc($resultSet)) {
                $stringGenero = "";

                $sql_generos = "SELECT nome FROM generos WHERE id = '$row[genero_id]'";

                $result_generos = mysqli_query($conn, $sql_generos);

                if (mysqli_num_rows($result_generos) > 0) {
                    while ($gen_row = mysqli_fetch_assoc($result_generos)) {
                        $stringGenero = $gen_row['nome'];
                    }
                }

                echo '<div class="card_book">';
                echo '<div class="titulo">' . htmlspecialchars($row['titulo']) . "</div>";
                echo '<div class="autor">' . htmlspecialchars($row['autor']) . "</div>";
                echo '<div class="genero">' . htmlspecialchars($stringGenero) . "</div>";
                echo '<div class="editora">' . htmlspecialchars($row['editora']) . "</div>";
                echo '<div class="ano">' . htmlspecialchars($row['ano_publicacao']) . "</div>";
                echo '<div class="classificacao">' . htmlspecialchars($row['classificacao']) . "</div>";
                echo ("<a class='btn btn-edit' href='./editar.php?id=" . urlencode($row['id'])) . "'>Editar</a>";
                echo ("<a class='btn btn-delete' href='excluir.php?id=" . urlencode($row['id'])) . "'>Excluir</a>";
                echo "</div>";
            }
        } else {
            echo "<tr><td colspan='4'>Nenhum registro encontrado.</td></tr>";
        }

        mysqli_close($conn); 

    ?>

    </div>
</body>
</html>