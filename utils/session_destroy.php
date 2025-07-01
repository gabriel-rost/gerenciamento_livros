<?php
	// session_destroy.php

	// inicia a sessão
	session_start();

	// encerrando a sessão
	session_destroy();

	header("location: /gerenciamento_livros/usuario/login/login.php");	
?>