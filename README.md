
# TrayChallengeAPI

Um projeto de teste para a empresa Tray, com o objetivo de cadastrar vendedores, vendas e calcular em cima da venda um percentual de comissão para o vendedor.
Um projeto construido com Laravel.

## Requisitos
Para utilizar o sistema você precisará utilizar: 

- [PHP](https://www.php.net/manual/en/install.php) 
- [Composer](https://getcomposer.org/)
- [Docker](https://www.docker.com/products/docker-desktop/)

## Clonar Repositório

Para iniciar, você precisa clonar o repositório em sua maquina, para isso
utilize o comando `git clone git@github.com:giovanelrocco/trayChallengeAPI.git`

## Configurar o ambiente
Após clonar o repositório, você precisa configurar o seu ambiente.
Basta você copiar o arquivo .env.docker.example para um novo arquivo .env `cp .env.docker.example .env`.

## Rodar o Composer
Após configurar o ambiente, você deverá rodar o composer para carregar as bibliotecas necessárias para o projeto `composer update`.

## Instanciar o projeto
Para iniciar o projeto em sua máquina, basta rodar o comando `docker-compose up -d`.

## Verificar nome da maquina docker
Para os próximos passos, será necessário utilizar o nome da maquina docker, para isso utilize o comando `docker ps`.
Ele lhe retornará uma lista com as maquinas criadas, você precisará do nome da maquina que possui a IMAGE sail-8.2/app.
Caso o nome seja muito extenso, você pode renomear utilizando o comando `docker rename {nome-atual-da-maquina} {novo-nome}`.

## Rodar Migrations
Para garantir que seu banco esteja atualizado, você precisa utilizar o comando
`docker exec {nome-maquina-docker} php artisan migrate`.

## Rodar Seeder no Docker
Para inserir as informações default no banco de dados, utilizar `docker exec {nome-maquina-docker} php artisan db:seed`.

## Testes
Para rodar os testes existentes utilize o comando `docker exec {nome-maquina-docker} php artisan test`.

## Rotas
Para facilitar o uso, você pode importar os arquivos de environment e collection que estão na pasta requisicoes-postman. Você encontrará todas as rotas disponíveis pelo sistema e o token já estará configurado assim que você fizer a chamada de login.
-Futuramente disponibilizaremos os arquivos para o insomnia.