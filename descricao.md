## Desenvolva um mini sistema web contendo as seguintes funcionalidades:

### 1. Autenticação de Usuário
* O sistema deve possuir uma tela de login, que faz a autenticação de usuário no banco de dados;
* Todas as páginas (exceto a de login) devem exigir autenticação prévia do usuário;
* Após o login bem-sucedido, o usuário deve ser redirecionado para a página principal do sistema.
### 2. Gerenciamento de Livros
Implemente um CRUD (create, retrieve, update, delete) para a tabela livros. O formulário de cadastro/edição deverá ter no mínimo os seguintes campos: (inputs)

* Titulo
* Autor
* Genêro (campo do tipo select, com os gêneros cadastradas previamente em uma tabela separada chamada generos) - relação entre as duas tabelas
* Editora
* Ano de publicação
* Indicação (campo do tipo radio button, com as opções: Para crianças, Para todas as idades ou Para adultos)

Além disso, implemente um CRUD para a tabela gêneros, permitindo gerenciamento dos gêneros de livros. Essa tabela pode ter apenas os campos id (PK) e gênero.

Com base nos requisitos, deve ser modelado o banco de dados, com as relações entre as tabelas e tipos de dados compatíveis com as informações solicitadas.

### 3. Recomendáveis desejáveis
* A interface do sistema deve seguir um padrão visual coerente, com boa usabilidade;
* Pode ser utilizado frameworks frontend para facilitar o desenvolvimento e manter o layout responsivo;
* Procure evitar a repetição de códigos, usando funções e/ou fazendo a inclusão de arquivos (exemplo: menus, conexão com o banco de dados entre outros);
* Procure utilizar consultas parametrizadas em todas as interações com o banco de dados, evitando assim vulnerabilidades do tipo SQL Injection.