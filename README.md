# back-vinho
Autora: Diovanna Schell

Projeto desenvolvido com Symfony framework na versão 6.0, PHP 8.1 e banco de dados Postgres. Com ele é possível fazer a gestão do cadastro de vinhos, geração de pedidos e cálculo de frete.

## Instalação
Requisitos para o projeto:
 - Ter o Docker instalado

Como o projeto foi desenvolvido usando o Docker, após clonar este repositório é possível rodar ele simplesmente utilizando o comando: 
```bash
docker compose up
```

Este comando criará dois containers sendo um para o PHP 8.1 já com as configurações para o Postgres, instalação do Symfony CLI e Composer e outro para o banco de dados usando o Postgres.

Além disto, este comando também rodará as migrations do projeto e deixará o symfony rodando no localhost:8000 do Docker.