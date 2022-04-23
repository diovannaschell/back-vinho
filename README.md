# back-vinho
Autora: Diovanna Schell

Projeto desenvolvido com Symfony framework na versão 6.0, PHP 8.0 e banco de dados Postgres. Com ele é possível fazer a gestão do cadastro de vinhos, geração de pedidos e cálculo de frete.

## Instalação
Requisitos para o projeto:
 - Ter o [Composer](https://getcomposer.org/) instalado
 - Docker
 - PHP 8.0 com as extensões para conexão com banco de dados Postgres habilitadas
 - Ter um servidor web rodando ou instalar o Symfony CLI conforme a [documentação](https://symfony.com/download)

Se o seu ambiente atender a todos estes requisitos, basta clonar o projeto e instalar suas dependências com o comando:
```bash
composer install
```

Após isto, se você está usando o Symfony CLI, basta rodar o servidor com o seguinte comando:
```bash
symfony server:start
```

## Banco de dados
Para este projeto foi usado um banco Postgres em docker. Para inicializar ele, basta rodar na pasta raiz do projeto o seguinte comando:
```bash
docker compose up -d
```

Para configurar nome do banco, usuário, senha e porta, altere as seguintes variáveis no arquivo .env:
```
POSTGRES_DB=teste
POSTGRES_PASSWORD=postgres
POSTGRES_USER=postgres
POSTGRES_HOST=127.0.0.1
POSTGRES_PORT=15432
```

Após isso, um banco em branco será criado e para criar a estrutura de tabelas rode o seguinte comando:
```bash
php bin/console doctrine:migrations:migrate
```

## Testes
Para rodar os testes do projeto, rode em seu console dentro da pasta do projeto o seguinte comando:
```bash
php bin/phpunit
```

## CORS
Se, ao consumir o back-end, forem apresentados erros de CORS altere no arquivo .env a variável ```CORS_ALLOW_ORIGIN``` conforme a sua necessidade.
