<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/mostrar_livros.css">
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
                echo ("<a class='btn btn-edit' href='./editar_livro/editar.php?id=" . urlencode($row['id'])) . "'>Editar</a>";
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

<style>
.card_book {
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 12px;
    margin: 10px 0;
    width: 300px;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
}

.card_book > div {
    margin-bottom: 6px;
}

.card_book .titulo {
    font-size: 18px;
    font-weight: bold;
    color: #333;
}

.card_book .autor {
    font-style: italic;
    color: #555;
}

.card_book .genero,
.card_book .editora,
.card_book .ano,
.card_book .classificacao {
    font-size: 14px;
    color: #444;
}

.books {
    align-items: center;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-content: flex-start;
    justify-content: space-around;
}



</style>