# App KaBuM

Front-end de um aplicativo de gerenciamento de clientes em Angular.

## Rodando localmente

Clone o projeto

```bash
  git clone https://github.com/CaduOly/gestao-clientes.git
```

Entre no diretório do projeto

```bash
  cd gestao-cliente/app-kabum
```

Instale as dependências

```bash
  npm install
```

Inicie o servidor

```bash
  ng serve
```

Será iniciado em `http://localhost:4200/`

## Sobre o projeto

### Tecnologias e versões:

- Angular: 16.2.12;
- PrimeNG: 16.9.1;
- PrimeFlex: 3.3.1;
- PrimeIcons: 6.0.1;

## Estrutura do projeto

- O projeto segue uma organização modular.

```plaintext
/src
|-- /app
|   |-- /clientes
|   |   |-- /components
|   |   |   |--/cliente
|   |   |   |--/cliente-list
|   |   |-- /models
|   |   |   |--cliente.ts
|   |   |   |--endereco.ts
|   |   |-- /service
|   |   |   |--cliente.service.ts
|   |   |-- cliente-routing.module.ts
|   |   |-- cliente.module.ts
|   |-- /core
|   |   |-- /auth
|   |   |   |--auth.service.ts
|   |   |-- /components
|   |   |   |--/header
|   |   |   |--/menu
|   |   |-- /guards
|   |   |   |--auth.guard.ts
|   |   |-- core.module.ts
|   |-- /login
|   |   |-- /components
|   |   |   |--login.component.css
|   |   |   |--login.component.html
|   |   |   |--login.component.ts
|   |   |-- /service
|   |   |   |--login.service.ts
|   |   |-- login-routing.module.ts
|   |   |-- login.module.ts
|   |-- /usuario
|   |   |-- /components
|   |   |   |--usuario.component.css
|   |   |   |--usuario.component.html
|   |   |   |--usuario.component.ts
|   |   |-- /service
|   |   |   |--usuario.service.css
|   |   |-- usuario-routing.module.ts
|   |   |-- usuario.module.ts
|   |-- app-routing.module.ts
|   |-- app.component.css
|   |-- app.component.html
|   |-- app.component.ts
|   |-- app.module.ts
|
|-- /assets
|
|-- /environments
|   |-- environment.ts
|   |-- environment.prod.ts
|-- /...
```

## Autores

- [@caduoly](https://www.github.com/caduoly)

TODOS OS DIREITOS DE IMAGENS E LAYOUTS SÃO DE PROPRIEDADE DO KABUM E DE SUA
EQUIPE.
