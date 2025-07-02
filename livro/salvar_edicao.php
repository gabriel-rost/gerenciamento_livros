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
                
                if (isset($id) && !empty($id))
                    $_SESSION["msg_sucesso"] = "Usuário atualizado com sucesso"; // armazena a mensagem de sucesso na variavel de sessão
                else
                    $_SESSION["msg_sucesso"] = "Usuário inserido com sucesso"; // armazena a mensagem de sucesso na variavel de sessão

                header("location: ./mostrar_livros.php");	// faz um redirecionamento para outra página
                
                mysqli_close($conn);	// fecha a conexão com o banco de dados
            } else {
                echo ("Houve um erro ao tentar inserir <br> " . mysqli_error($conn) );
            }

        } else {
            die("Houve um erro ao conectar com o banco de dados");
        }
    }

?>