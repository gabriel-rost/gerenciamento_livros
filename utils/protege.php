<?php
	// protege.php

	session_start();

	// se o usuário não está autenticado
	if (!isset($_SESSION["usuario"]) ){
		$_SESSION["erro"] = "Você precisa estar logado para acessar essa página";	// define uma mensagem personalizada

		// redireciona para a página de login
		// /login.php faz um redirecionamento absoluto para a raiz do site
		header("location: /gerenciamento_livros/usuario/login/login.php");	
	}

?>