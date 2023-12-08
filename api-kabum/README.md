# Api KaBuM

Back-end de um sistema de gerenciamento de clientes em PHP puro.

## Rodando localmente

Clone o projeto

```bash
  git clone https://github.com/CaduOly/gestao-clientes.git
```

Entre no diretório do projeto

```bash
  cd gestao-cliente/api-kabum
```

Instale as dependências

```bash
 compose install
```

Inicie o servidor

```bash
$ php -S localhost:8000 app/index.php
```

Lembre-se de estar com o banco de dados ativo.

Server será iniciado em `http://localhost:8000/`

## Rodando testes

Para iniciar os testes usando PHPUnit use o comando:

```bash
$ composer test tests/clienteTest
```

## Estrutura do projeto

-   O projeto segue a arquitetura MVC.

```plaintext
/src
|-- /app
|   |-- /controllers
|   |   |--clienteController.php
|   |-- /models
|   |   |--Cliente.php
|   |   |--Endereco.php
|   |-- /repositories
|   |   |   |--clienteRepository.php
|   |-- /services
|   |   |-- ClienteService.php
|   |-- index.php
|-- /config
|   |-- /db.php
|-- /logs
|-- /public
|-- /tests
|-- /vendor
|-- /...
```

## Documentação da API

#### Retorna todos os clientes

```http
  GET cliente/
```

#### Retorna um cliente

```http
  GET /cliente/${id}
```

| Parâmetro | Tipo     | Descrição                                   |
| :-------- | :------- | :------------------------------------------ |
| `id`      | `string` | **Obrigatório**. O ID do item que você quer |

#### Cadastrar cliente

```http
  POST /cliente/cadastro
  Content-Type: application/json
```

| Parâmetro         | Tipo     | Descrição                                     |
| :---------------- | :------- | :-------------------------------------------- |
| `nome`            | `string` | **Obrigatório** Nome do cliente               |
| `cpf`             | `string` | **Obrigatório** CPF do cliente                |
| `rg`              | `string` | **Obrigatório** RG do cliente                 |
| `data_nascimento` | `string` | **Obrigatório** Data de nascimento do cliente |
| `telefone`        | `string` | **Obrigatório** Telefone do cliente           |
| `enderecos`       | `array`  | **Obrigatório** Enderecos do cliente          |
| `cep`             | `string` | **Obrigatório**                               |
| `logradouro`      | `string` | **Obrigatório**                               |
| `numero`          | `string` |                                               |
| `complemento`     | `string` |                                               |
| `bairro`          | `string` | **Obrigatório**                               |
| `localidade`      | `string` | **Obrigatório**                               |
| `uf`              | `string` | **Obrigatório**                               |

Exemplo corpo da requisição:

```JSON
  {
    "nome": "Fulano",
    "cpf": "12345634588",
    "rg": "1234567",
    "data_nascimento": "2001/07/29",
    "telefone": "61983340967",
    "enderecos": [
        {
            "cep": "71571-102",
            "numero": "",
            "logradouro": "Quadra 11 Conjunto B",
            "complemento": "",
            "bairro": "Paranoá",
            "localidade": "Brasília",
            "uf": "DF"
        },
        {
            "cep": "71571-102",
            "numero": "324234",
            "logradouro": "Quadra 11 Conjunto D",
            "complemento": "342",
            "bairro": "Paranoá",
            "localidade": "Brasília",
            "uf": "DF"
        }
    ]
}
```

#### Atualizar Cliente

```http
  PUT /cliente/{id}
  Content-Type: application/json
```

| Parâmetro         | Tipo     | Descrição                                     |
| :---------------- | :------- | :-------------------------------------------- |
| `nome`            | `string` | **Obrigatório** Nome do cliente               |
| `cpf`             | `string` | **Obrigatório** CPF do cliente                |
| `rg`              | `string` | **Obrigatório** RG do cliente                 |
| `data_nascimento` | `string` | **Obrigatório** Data de nascimento do cliente |
| `telefone`        | `string` | **Obrigatório** Telefone do cliente           |
| `enderecos`       | `array`  | **Obrigatório** Enderecos do cliente          |
| `id`              | `string` | ID do endereço                                |
| `cep`             | `string` | **Obrigatório**                               |
| `logradouro`      | `string` | **Obrigatório**                               |
| `numero`          | `string` |                                               |
| `complemento`     | `string` |                                               |
| `bairro`          | `string` | **Obrigatório**                               |
| `localidade`      | `string` | **Obrigatório**                               |
| `uf`              | `string` | **Obrigatório**                               |
| `id_cliente`      | `string` | **Obrigatório**                               |

Exemplo corpo da requisição:

```JSON
  {
    "nome": "Fulano",
    "cpf": "12345634588",
    "rg": "1234567",
    "data_nascimento": "2001/07/29",
    "telefone": "61983340967",
    "enderecos": [
        {
            "id": 1,
            "cep": "71571-102",
            "numero": "",
            "logradouro": "Quadra 11 Conjunto B",
            "complemento": "",
            "bairro": "Paranoá",
            "localidade": "Brasília",
            "uf": "DF",
             "id_cliente": 1
        },
        {
            "id": 2,
            "cep": "71571-102",
            "numero": "324234",
            "logradouro": "Quadra 11 Conjunto D",
            "complemento": "342",
            "bairro": "Paranoá",
            "localidade": "Brasília",
            "uf": "DF",
            "id_cliente": 1
        }
    ]
}
```

#### Deleta o cliente

```http
  DELETE cliente/{id}
```

## Autores

-   [@caduoly](https://www.github.com/caduoly)
