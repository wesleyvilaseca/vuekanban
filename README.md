<h1 align="center">VUE KANBAN</h1>

<p align="center">
    <img src="https://img.shields.io/static/v1?label=license&message=MIT&color=0d7bbd" />
    <img src="https://img.shields.io/static/v1?label=version&message=BETA&color=0d7bbd" />
</p>



<p align="center">🚀 Desenvolvimento de um sistema que facilita a organização de atividade e projetos, utilizando o modo kanban.</p>

<h3>Índice</h3>

<!--ts-->
* [Instalação](#instalação)
* [Bando de dados](#banco-de-dados)
* [Rodando o projeto](#rodando-o-projeto)
* [Acessos](#acessos)
<!--te-->

## Pré-requisitos

Antes de começar, você vai precisar ter instalado em sua máquina as seguintes ferramentas:

- [Composer](https://getcomposer.org/)
- [Node](https://nodejs.org/en/)
- Banco de dados MySql
- Servidor Apache
- PHP 7.4+


## Instalação

Para instalação clone ou baixe o projeto e depois disso acesse a pasta ``/backend`` e altera as configurações do arquivo ``.env`` pela suas informações de conexão com o banco de dados. 
<br>

Depois acesse a pasta ``/frontend`` e rode o comando ``npm install``, para poder instalar os pacotes necessários. <br>


## Banco de dados


Acesse a pasta ``/backend`` e rode o comando ``php artisan migrate`` para que as tabelas do banco de dados sejam criadas. 
<br>

Após rode o comando ``php artisan db:seed`` para que o usuário inicial seja criado.


## Rodando o projeto

Acesse a pasta ``/backend`` e rode o comando ``php artisan serve --port=8001``. <br>
Após acesse a pasta ``/frontend`` e rode o comando ``npm run serve`` para que o front-end seja iniciado. <br>

Acesse o link ``http://localhost:8080``


## Acessos

Usuário para acesso <br>

- E-mail: wesley@gmail.com
- Senha: 123456

