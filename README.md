# ChefBook API

API REST para gerenciamento de receitas gastronômicas desenvolvida em PHP puro com Slim Framework 4.


## Descrição

A **ChefBook API** é uma aplicação backend que permite o cadastro e gerenciamento de receitas culinárias, seus ingredientes e categorias.

O projeto foi desenvolvido com foco em:

- Arquitetura em camadas
- Separação de responsabilidades
- Uso de PDO com prepared statements
- Paginação e filtros
- Validação manual de dados
- Testes unitários com Kahlan

Este projeto faz parte do meu processo de aprofundamento em desenvolvimento backend com PHP moderno.


## 🚀 Features

- CRUD completo de Receitas
- CRUD de Ingredientes
- CRUD de Categorias
- Filtro por nome da receita
- Filtro por ingrediente
- Paginação Offset-Limit
- Tratamento centralizado de erros
- Migrations com Phinx
- Ambiente isolado com Docker
- Testes unitários

## 💻 Tecnologias

- PHP 8.2
- Slim Framework 4
- PDO
- MySQL 8
- Docker
- Composer
- Phinx
- Kahlan
- Dotenv

## 📦 Requisitos

Antes de começar, você precisa ter instalado:

- PHP 8.2+
- Composer
- Docker e Docker Compose
- Git

## 🛠️ Instalação

###  Clone o repositório

```bash
git clone https://github.com/seu-usuario/chefbook.git
cd chefbook
```

### Preparar o Ambiente PHP

Este projeto utiliza o **mise** para gerenciar versões de runtime. Se você o tiver instalado:

```bash
mise install  # Instala o PHP 8.2 configurado no mise.toml
```

### Instale as dependências

```bash
composer install
```

### Configure o arquivo .env

```bash
cp .env.example .env
```
**Importante:** Se você estiver rodando o PHP localmente e o MySQL dentro do container, configure o DB_HOST=127.0.0.1 no seu .env.

Configure as variáveis:

DB_HOST=  
DB_PORT=  
DB_ROOT_PASSWORD=  
DB_NAME=  
DB_USER=  
DB_PASS=

### Suba o banco de dados

```bash
docker compose up -d
```

### Execute as migrations

```bash
vendor/bin/phinx migrate
```
### Inicie a aplicação

```bash
php -S localhost:8000 -t public
```
A API estará disponível em: http://localhost:8000

### Rodar os testes

O projeto utiliza Kahlan para testes unitários.

Execute:

```bash
composer test
```

## API Endpoints

Todas as respostas são retornadas em formato JSON.

### Receitas

`POST /receitas`

Request Body:
```bash
{
  "nome": "Bolo de Chocolate",
  "descricao": "Misture tudo e asse",
  "tempoDePreparo": 40,
  "nivel": "FACIL",
  "categoria": "Doce",
  "ingredientes": [
    {
      "ingredienteId": 1,
      "quantidade": 2,
      "unidade": "xicaras"
    },
    {
      "ingredienteId": 7,
      "quantidade": 4,
      "unidade": "colheres"
    },
    ...
  ]
}
```

`GET /receitas`
Lista todas as receitas com suporte a busca e paginação.

**Parâmetros de Query:**

| Parâmetro | Tipo | Padrão | Descrição |
| :--- | :--- | :--- | :--- |
| `nome` | `string` | - | Filtra receitas pelo nome. |
| `ingrediente` | `string` | - | Filtra receitas que contenham o ingrediente. |
| `offset` | `int` | `0` | Quantidade de registros ignorados. |
| `limit` | `int` | `10` | Quantidade máxima de registros retornados. |

**Exemplos de chamadas:**
* `GET /receitas?nome=bolo`
* `GET /receitas?offset=10&limit=10`

---

#### Detalhes de Receita
| Método | Endpoint | Descrição |
| :--- | :--- | :--- |
| `GET` | `/receitas/{id}` | Retorna os detalhes de uma receita específica. |
| `PUT` | `/receitas/{id}` | Atualiza os dados de uma receita existente. |

---

### Ingredientes

Gerenciamento do catálogo de ingredientes disponíveis.

| Método | Endpoint | Descrição |
| :--- | :--- | :--- |
| **POST** | `/ingredientes` | Cadastra um novo ingrediente. |
| **GET** | `/ingredientes` | Lista todos os ingredientes. |
| **GET** | `/ingredientes/{id}` | Visualiza um ingrediente específico. |

---

### Categorias

Organização das receitas por tipos (ex: Doces, Massas, Veganas).

| Método | Endpoint | Descrição |
| :--- | :--- | :--- |
| **POST** | `/categorias` | Cria uma nova categoria. |
| **GET** | `/categorias` | Lista todas as categorias. |
| **GET** | `/categorias/{id}` | Detalha uma categoria específica. |

## Author

Tobias FS

Projeto desenvolvido para estudo e portfólio.