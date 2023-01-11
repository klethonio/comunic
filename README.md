<!-- PROJECT SHIELDS -->
![GitHub language count][language-count] ![GitHub top language][top-language] [![LinkedIn][linkedin-shield]][linkedin-url]

<a  name="readme-top"></a>

# Comunic Notícias

Sistema de notícias desenvolvido para a Comunidade Universitária de Coremas em 2016. 

<p align="right">(<a href="#readme-top">back to top</a>)</p>


## Descrição do projeto

O sistema gerencia categorias e subcategorias de notícia, cadastra artigos, páginas estáticas e galeria de imagens para eventos.

Cadastra leitores e registra todas as estatísticas relacionadas a visualizações, ainda com potencial para inserir comentários e aumentar a interação entre os usuários.

<p align="right">(<a href="#readme-top">back to top</a>)</p>


## Tecnologias  

* [![PHP][PHP.com]][PHP-url]
* [![MySQL][MySQL.com]][MySQL-url]
* [![HTML5][HTML5.com]][HTML5-url]
* [![CSS3][CSS3.com]][CSS3-url]
* [![JQuery][javascript.com]][javascript-url] [![JQuery][JQuery.com]][JQuery-url]

<p align="right">(<a href="#readme-top">back to top</a>)</p>
  
  
## Instalação

### Configurações Iniciais

No arquivo `dts/iniSis.example.php` você pode configurar o banco de dados, servidor de e-mail e os demais dados do blog, renomeie esse arquivo para `dts/iniSis.php`.  As principais são: 

   ```php  
// You need to trim the slashs
define('BASE', 'http://localhost'); 

// MySQL
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBSA', 'comunic');  

// Mail
define('MAILUSER', '');
define('MAILPASS', '');
define('MAILPORT', '');
define('MAILHOST', '');

// File Manager
/*
| path from base_url to base of project ie. for http://localhost/blog/ type /blog/
| if it is based on root, leave a '/'
| !!! with start and final /
*/
define('FILEMANAGER_DIR', '/');
   ```

### Banco de dados

A pasta raiz do projeto tem o arquivo `comunic.sql`, você pode restaurar o banco de dados no seu servidor a partir desse arquivo.

Três registros de página estática estão inseridos no backup, `ative-sua-conta`, `sucesso-ao-ativar`, `erro-ao-ativar`, que podem ser editadas, assim como o usuário padrão, `admin@admin.com`, `123456`, respectivos usuário e senha.

### File Manager

Tenha certeza de que as pastas `uploads` e `thumbs` estão criadas na base do projeto, o funcionamento do File Manager depende disso.

<p align="right">(<a href="#readme-top">back to top</a>)</p>


## Começando

Acessando `/admin` a partir da base do projeto você conseguirá acessar o painel administrador, adicione categorias, no mínimo quatro, e a partir daí é possível criar artigos.

### Páginas de cadastro

As página de ativação de usuário já foram pré-cadastradas no banco, seus nomes são `Ative sua conta (ative-sua-conta)`, `Sucesso ao ativar (sucesso-ao-ativar)`, `Erro ao ativar (erro-ao-ativar)`. Também é possível editá-las com o intuito de melhorar a apresentação.

### Áreas do blog

No admin, será necessário configurar as 4 áreas de categorias para a página inicial e para a página 404.


## Add-ons / Plugins

* File Manager
* Tiny MCE
* Fancy Uploader

<p align="right">(<a href="#readme-top">back to top</a>)</p>


## Versão do PHP

A versão utilizada na criação do projeto foi `php 5.2.6`, mas o projeto foi adaptado para `php 8.0.12`. Alguns plugins foram modificados para se adequarem a versão do PHP.

<p align="right">(<a href="#readme-top">back to top</a>)</p>


## Contato
  
Klethonio Lacerda - klethonio@gmail.com

Linkedin: [https://www.linkedin.com/in/klethonio-lacerda/](https://www.linkedin.com/in/klethonio-lacerda/)

Link do Projeto: [https://github.com/klethonio/comunic](https://github.com/klethonio/comunic)

<p align="right">(<a href="#readme-top">back to top</a>)</p>
  
  

<!-- MARKDOWN LINKS & IMAGES -->
[top-language]: https://img.shields.io/github/languages/top/klethonio/comunic?style=for-the-badge
[language-count]: https://img.shields.io/github/languages/count/klethonio/comunic?style=for-the-badge

[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/othneildrew  

[PHP.com]: https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white
[PHP-url]: https://php.net 
[MySQL.com]: https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white
[MySQL-url]: https://www.mysql.com/
[HTML5.com]: https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white
[HTML5-url]: https://html.com/html5/
[CSS3.com]: https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white
[CSS3-url]: https://developer.mozilla.org/en-US/docs/Web/CSS
[javascript.com]: https://img.shields.io/badge/javascript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=white
[javascript-url]: https://www.javascript.com/
[JQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[JQuery-url]: https://jquery.com