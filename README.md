## Sobre o Projeto

Um sistema web cuja finalidade é
realizar o cadastro das vendas para vendedores e calcular a comissão sobre elas.

## Requisitos

Make sure you have installed in your computer 
- [PHP](https://www.php.net/manual/en/install.php) 
- [Composer](https://getcomposer.org/)
- [Docker](https://www.docker.com/products/docker-desktop/)


## Clone Repo

Utilizar o comando `git clone git@github.com:giovanelrocco/trayChallengeAPI.git`

## Rodar o Composer

Utilizar o comando `composer update`

## Configurar o ambiente
Copiar o arquivo .env.example para um novo arquivo .env `cp .env.example .env`

## Instanciar o projeto

Para rodar o projeto utilize `docker-compose up -d`

## Rodar Migrations no Docker

Utilizar comando `php artisan migrate` no container docker

## Rodar Seeder no Docker

Utilizar comando `php artisan db:seed` no container docker