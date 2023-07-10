
# API de imóveis em PHP

Projeto feito baseado na ideia de anúncio de aluguel e venda de imóveis.




## Instalação:

O projeto possui um docker composer com todas as configurações já preparadas pra uso.

Basta clonar o projeto, entrar na pasta e executar o comando para iniciar os containers

```bash
git clone git@github.com:theus-figueiredo/laravel-api.git
cd laravel-api
vendor/bin/sail up -d
```

Não há a necessidade iniciar o servidor pelo PHP artisan, uma vez que os containers forem iniciados o seridor já estará rodando.

No projeto há um arquivo exemplo de um .env, você pode usa-lo como base para criar um .env no projeto e alterar as informações conforme queira mudar algo no mesmo.

## Sobre as portas dos containers:

A aplicação está sendo redirecionado para a porta local: 8787

O MySQL está sendo redirecionado para a porta local: 3358

caso você possua alguma aplicação local sendo executada em alguma desas portas, você pode alterar as mesmas no arquivo .env do projeto, ou diretamente no arquivo do docker-compose
## Rotas da API

#### Recuperar todos os imóveis

```http
  GET http://localhost:8787/api/v1/real-state/
```

---------------------------------------------------------

#### Recuperar imóvel por id

```http
  GET http://localhost:8787/api/v1/real-state/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |


---------------------------------------------------------

#### Adicionar um novo imóvel:

```http
  POST http://localhost:8787/api/v1/real-state/
```
Corpo da requisição:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `title`      | `string` | **Obrigatório**. título do anúncio |
| `description`      | `string` | **Obrigatório**. descrição do anúncio|
| `price`      | `float` | **Obrigatório**. valor do imóvel |
| `bathrooms`      | `int` | **Obrigatório**. quantidade de banheiros |
| `bedrooms`| `int` | **Obrigatório**. quantidade de quartos |
| `property_area` | `int` | **Obrigatório**. área do imóvel |
| `total_area` | `int` | **Obrigatório**. área do terreno |
| `categories[]` | `int` | **Obrigatório**. id da categora do anúncio |

Header:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer token` | **Obrigatório**. Token JWT do usuário logado |



Opa... esse readme ainda está em desenvolvimento, já já vão ter mais informações