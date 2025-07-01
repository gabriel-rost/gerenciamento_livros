<?php
    require_once '../../db/db_config.php';

    function sha512($string){
		return (hash("sha512", $string) );
	}

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Conectar ao banco de dados
        $conn = new mysqli($db_host, $db_user, $db_password, $db_name, $db_port);

        // Verificar conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Obter dados do formulário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $usuario = $_POST['usuario'];
        $senha = sha512($_POST['senha']); // Hash da senha

        // Preparar e executar a consulta SQL
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, usuario, senha) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $usuario, $senha);

        if ($stmt->execute()) {
            echo "Usuário registrado com sucesso!";
        } else {
            echo "Erro ao registrar usuário: " . $stmt->error;
        }

        // Fechar conexões
        $stmt->close();
        $conn->close();
    }
?>