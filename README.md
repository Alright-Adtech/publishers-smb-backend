# <img src="./docs/images/publishers-smb-logo.png" width="25px" height="25px" /> Backend | Publishers SMB

Sistema utilizado para Publishers Express (SMB).

## Tecnologias utilizadas
- Laravel com PHP 8.2+
- MySQL
- Docker e docker-compose

## Requisitos
- Docker
- docker-compose

## Começando

Primeiro vamos clonar o projeto:

```shell
$ git clone git@github.com:Alright-Adtech/publishers-smb-backend.git
```

Entre na pasta do projeto clonado, instale as dependências:

```shell
$ cd publishers-smb-backend/ # Entre na pasta do projeto
$ cp .env.example .env # Copie as configurações de ambiente local
$ make install # Intale as dependências do backend
$ make up # Inicie o servidor backend em background
$ make migrate # Executa as migrações do banco de dados
$ make generate # Cria as chaves nescessárias
```

### Problemas que podem ocorrer
Em alguns sistemas operacionais como mac e linux, será nescessário adicionar permissões no diretório do projeto para que ele pertença ao seu usuário não root:

```shell
$ id -u # Obtem o userid
$ sudo chown -R ${userid}:${userid} ./publishers-smb-backend # alterar userid para ID retornado no comando anterior
```

## Scripts

Na pasta do projeto, você pode executar:

### `make up`

Constrói, (re)cria, inicia e anexa contêineres para um serviço.

### `make stop`

Interrompe e remove contêineres, redes, volumes e imagens criadas por up.

### `make install`

Instala todas as dependências no backend.

### `make migrate`

Realiza todas as migrações no banco de dados.

### `make generate`

Cria as chaves nescessárias.

### `make terminal`

Interaja dentro do contêiner da aplicação `app`.

### `make logs`

Mostrar registros de contêiner da aplicação `app`.

### `make inspect`

Inspecione o contêiner da aplicação `app`.

### `make composer`

Instala as dependências do backend.

### `make help`

Mostra todos os comandos disponíveis.

## Links úteis

- [Laravel](https://laravel.com/)
- [PHP](https://www.php.net/)
- [TypeScript](https://www.typescriptlang.org/)
- [MySQL](https://www.mysql.com/)
- [Docker](https://www.docker.com/)
- [docker-compose](https://docs.docker.com/compose/)