<?php
    require_once("../db/db_config.php");
    require_once("./../utils/protege.php");
    require_once("./../utils/nav.php");

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

    // Preparar e executar a consulta SQL
    $stmt = $conn->prepare("INSERT INTO livros (titulo, autor, genero_id, editora, ano_publicacao, classificacao) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $titulo, $autor, $genero_id, $editora, $ano, $classificacao);

    if ($stmt->execute()) {
        echo "Livro cadastrado com sucesso!";
    } else {
        echo "Erro ao registrar livro: " . $stmt->error;
    }

    // Fechar conexões
    $stmt->close();
    $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/cadastrar_livros.css">
    <title>Cadastrar Livro</title>
</head>
<body>
    <form action="" method="post">
        <label for="titulo">
            Título:
        </label>
        <input type="text" name="titulo" id="titulo">
        <label for="autor">
            Autor:
        </label>
        <input type="text" name="autor" id="autor">
        <label for="genero">
            Gênero:
        </label>
        <select name="genero" id="genero">

        <?php
        $conn = mysqli_connect("localhost", "root", "", "vbooks");

        // testa se a conexão ocorreu com sucesso
        if (!$conn){
            die("Houve um erro ao conectar com o banco de dados");
        }

        // gerar a string de consulta sql
        $sql = "SELECT id, nome FROM generos ORDER BY nome ASC";

        $resultSet = mysqli_query($conn, $sql); 

        if (mysqli_num_rows($resultSet) > 0) {

            // Recupera a próxima linha do resultado da consulta como um array associativo,
            while ($row = mysqli_fetch_assoc($resultSet)) {
                echo '<option value=" ' . htmlspecialchars($row['id']) . '">'  . htmlspecialchars($row['nome']) . '</option>';
            }
        } else {
            echo "<tr><td colspan='4'>Nenhum registro encontrado.</td></tr>";
        }

        mysqli_close($conn); 
        ?>

        </select>
        <label for="editora">
            Editora:
        </label>
        <input type="text" id="editora" name="editora">
        <label for="ano">
            Ano:
        </label>
        <input type="number" id="ano" name="ano">
        <div class="classificacao-group">
            <label>
                Classificação Indicativa
            </label>
        <p>Insira a classificaçã indicativa:</p>
          <input type="radio" id="criancas" name="classificacao" value="Crianças">
          <label for="criancas">Crianças</label><br>
          <input type="radio" id="todas_idades" name="classificacao" value="Todas as idades">
          <label for="todas_idades">Todas as idades</label><br>
          <input type="radio" id="adulto" name="classificacao" value="Adulto">
          <label for="adulto">Adulto</label>
        </div>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>