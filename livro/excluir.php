<?php
	// excluir.php
	require_once("./../utils/protege.php");

	$id = $_GET["id"];	// recuperando o paremtro da url

	require("./../db/conecta.php");	// incluindo o  arquivo que faz a conexão com o banco de dados

	$sql = "DELETE FROM livros WHERE id = $id";

	if (mysqli_query($conn, $sql) ){
		// consulta exececutada com sucesso
		// mysqli_affected_rows conta quantas linhas foram afetadas na última consulta executada. É importante essa verificação, pois pode acontecer de ser usado um id que não existe, de modo que a consulta vai ser executada com sucesso, mas não quer dizer que houve a exclusão de um registro
		if (mysqli_affected_rows($conn) == 1){
			session_start();
			$_SESSION["msg_sucesso"] = "Registro excluído com sucesso";
		}
	} else {
		echo ("Houve um erro ao excluir o registro");
	}
	
	header("location: ./../index.html");

?>