
# API de imóveis em PHP

Projeto feito baseado na ideia de anúncio de aluguel e venda de imóveis.




## Instalação:

_Necessário ter o docker instalado para seguir o passo a passa abaixo_

Para executar o projeto basta seguir os passos abaixo:

1 - clonar o projeto

```bash
git clone git@github.com:theus-figueiredo/real-state-api.git
```

2- entrar na pasta e executar o comando para iniciar os containers

```bash
cd real-state-api
docker-compose up -d
```

3 - entrar no bash do container onde a aplicação está e executar as migrations

```bash
docker-compose exec laravel.test php artisan migrate
```

Não há a necessidade iniciar o servidor pelo PHP artisan, uma vez que os containers forem iniciados o seridor já estará rodando.

## Variáveis de ambiente

Para executar o projeto é preciso adicionar algumas variais de ambiente:

`APP_PORT` -> irá definir a porta local em que a aplicação será executada

`FORWARD_DB_PORT` -> irá definir a porta local para qual será mapeado o container com o mysql

`JWT_SECRET` -> para fazer uso das funções do JWT

`APP_KEY` -> para armazenar a chave de criptografia usada para proteger os dados sensíveis do aplicativo


o username e senha do mysql no container em questão são respectivamente `sail` e `password`

No projeto há um arquivo .env.example com um exemplo do arquivo .env, use-o como base.

## Endpoint de imóveis:

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
| `images[]` | `file` |  Foto |

Header:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer token` | **Obrigatório**. Token JWT do usuário logado |

--------------------------------------------------------

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


### Atualizar um Imóvel


```http
  PUT http://localhost:8787/api/v1/real-state/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Obrigatório**. Id do item       |

Corpo da requisição:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `title`      | `string` | título do anúncio |
| `description`      | `string` | descrição do anúncio|
| `price`      | `float` |  valor do imóvel |
| `bathrooms`      | `int` |  quantidade de banheiros |
| `bedrooms`| `int` |  quantidade de quartos |
| `property_area` | `int` |  área do imóvel |
| `total_area` | `int` |  área do terreno |
| `categories[]` | `int` |  id da categora do anúncio |
| `images[]` | `file` |  Foto |


Header:
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer token` | **Obrigatório**. Token JWT do usuário logado |


----------------------------------------------------------

### Deletar um Imóvel

```http
  PUT http://localhost:8787/api/v1/real-state/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Obrigatório**. Id do item       |


Header:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer token` | **Obrigatório**. Token JWT do usuário logado |

## Endpoint de usuários

### Resgatar usuários:

```http
  GET http://localhost:8787/api/v1/users/
```

Header:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer token` | **Obrigatório**. Token JWT do usuário logado |


### Resgatar usuário por id


```http
  GET http://localhost:8787/api/v1/users/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Obrigatório**. Id do item       |

Header:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer token` | **Obrigatório**. Token JWT do usuário logado |


### Criar um novo usuário:

```http
  POST http://localhost:8787/api/v1/users/
```

Corpo da requisição:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name`      | `string` | **Obrigatório**. Nome do usuário |
| `email`     | `string` | **Obrigatório**. Email do usuário|
| `password`  | `string` | **Obrigatório**. senha           |
| `profile[mobile_phone]` | `string` | **Obrigatório**. celular |
| `profile[about]`| `string` | Sobre |
| `profile[social_networks][]` | `string` | Redes sociais |



### Atualizar um usuário:

```http
  PUT http://localhost:8787/api/v1/users/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Obrigatório**. Id do item       |


Header:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer token` | **Obrigatório**. Token JWT do usuário logado |


Corpo da requisição:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name`      | `string` | Nome do usuário |
| `email`     | `string` | Email do usuário|
| `password`  | `string` | senha           |
| `profile[mobile_phone]` | `string` | celular |
| `profile[about]`| `string` | Sobre |
| `profile[social_networks][]` | `string` | Redes sociais |

### Deletar usuário:

```http
    DELETE http://localhost:8787/api/v1/users/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Obrigatório**. Id do item       |


Header:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer token` | **Obrigatório**. Token JWT do usuário logado |


## Resgatar os imóveis postados por um usuário:

```http
    GET http://localhost:8787/api/v1/user-real-state
```

Header:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer token` | **Obrigatório**. Token JWT do usuário logado |


### Login:

Retorna o token de autenticação JWT do usuário

```http
    POST http://localhost:8787/api/v1/users/login
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email`   | `string` | **Obrigatório**. Email do usuário |
| `password`| `string` | **Obrigatório**. Senha do usuário |


### Logout:

Invalida o token JWT do usuário.

```http
    GET http://localhost:8787/api/v1/users/logout
```

Header:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer token` | **Obrigatório**. Token JWT do usuário logado |


### Refresh:

Atualiza o Token JWT do usuário.

```http
    GET http://localhost:8787/api/v1/users/refresh
```

Header:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer token` | **Obrigatório**. Token JWT do usuário logado |


### Endpoints de categorias:

Todos os endpoints dentro de categorias requerem o envio do token JWT no Header:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer token` | **Obrigatório**. Token JWT do usuário logado |

## Resgatar categorias:

```http
    GET http://localhost:8787/api/v1/categories/
```


## Resgatar categorias por id:

```http
    GET http://localhost:8787/api/v1/categories/{id}
```

## Adicionar uma categoria:

```http
    POST http://localhost:8787/api/v1/categories/
```

Corpo da requisição:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name`   | `string` | **Obrigatório**. Nome da categoria |
| `description`| `string` | **Obrigatório**. descrição     |

## Atualizar uma categoria:

```http
    PUT http://localhost:8787/api/v1/categories/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Obrigatório**. Id do item       |

Corpo da requisição:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name`   | `string` | **Obrigatório**. Nome da categoria |
| `description`| `string` | **Obrigatório**. descrição     |


## Deletar uma categoria:

```http
    DELETE http://localhost:8787/api/v1/categories/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Obrigatório**. Id do item       |


## Resgatar imóveis que fazer parte de uma categoria:

```http
    GET http://localhost:8787/api/v1/categories/{id}/real-states
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Obrigatório**. Id do item       |


### Endpoints de Fotos:

Todos os endpoints dentro de fotos requerem o envio do token JWT no Header:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer token` | **Obrigatório**. Token JWT do usuário logado |

## Deletar uma foto:

```http
    DELETE http://localhost:8787/api/v1/photos/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Obrigatório**. Id do item       |


## Definir uma imagem como thumbnail:

```http
    PUT http://localhost:8787/api/v1/photos/set-thumb/{photoId}/{realStateId}
```

| Parameter     | Type     | Description                       |
| :------------ | :------- | :-------------------------------- |
| `photoId`     | `string` | **Obrigatório**. Id da foto       |
| `realStateId` | `string` | **Obrigatório**. Id do imóvel     |

