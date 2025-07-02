<?php
    //<a href="./../usuario/login/login.php">Login</a>


    echo '
    <nav class="nav">
        <a href="./../livro/mostrar_livros.php">Home</a>
        <a href="./../livro/cadastrar_livro.php">Cadastrar Livro</a>
        <a href="./../utils/session_destroy.php">Sair</a>
    </nav>

    <style>
    /* Estilos Gerais para o Corpo (opcional, para melhor visualização) */
    body {
        margin: 0;
        font-family: Arial, sans-serif; /* Define uma fonte padrão */
        background-color: #f4f4f4; /* Cor de fundo suave para o corpo */
    }

    /* Estilos da Barra de Navegação */
    .nav {
        display: flex;
        flex-direction: row;
        justify-content: center; /* Centraliza os itens na barra */
        align-items: center;
        background-color: #2c3e50; /* Cor de fundo escura (azul marinho) */
        padding: 15px 20px; /* Espaçamento interno (topo/base e laterais) */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Sombra suave para profundidade */
        width: 100%; /* Garante que ocupe toda a largura */
        box-sizing: border-box; /* Inclui padding na largura total */
    }

    /* Estilos dos Links da Barra de Navegação */
    .nav a {
        color: #ecf0f1; /* Cor do texto dos links (cinza claro) */
        text-decoration: none; /* Remove o sublinhado padrão */
        padding: 10px 20px; /* Espaçamento interno para cada link */
        margin: 0 10px; /* Espaçamento entre os links */
        font-weight: bold; /* Deixa o texto em negrito */
        font-size: 1.1em; /* Tamanho da fonte um pouco maior */
        transition: background-color 0.3s ease, color 0.3s ease; /* Transição suave para hover */
        border-radius: 5px; /* Bordas levemente arredondadas */
    }

    /* Efeito ao Passar o Mouse (Hover) */
    .nav a:hover {
        background-color: #34495e; /* Fundo mais escuro ao passar o mouse */
        color: #ffffff; /* Texto branco puro ao passar o mouse */
    }
    </style>
    ';

?>