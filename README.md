# API de Catálogo de filmes favoritos buscando filmes da API externa TMDB (Laravel 12 + PHP 8.2 + MySQL 8 + Docker)

## Desenvolvido por Bruno Corral

Este projeto foi desenvolvido como parte do processo seletivo para a vaga Desenvolvedor(a) Full Stack Júnior - Kinghost, atendendo a todos os requisitos funcionais, técnicos e diferenciais solicitados.

A API realiza a busca de filmes da API externa TMDB, a busca de filmes baseada no nome do filme da API externa TMDB, a busca de filmes favoritos da API externa TMDB, a inclusão de filmes favoritos (salva localmente no banco e na API externa TMDB) e a deleção de filmes baseado no id do filme (deleta localmente no banco).

---

## Tecnologias utilizadas

- PHP 8.2
- Laravel 12.x
- MySQL 8.x
- Docker (PHP + Nginx + MySQL)
- GIT para versionamento do projeto

---

## Instalação e configuração

### Clonando o projeto
```bash
git clone https://github.com/seu-usuario/app_filmes_tmdb
cd app_filmes_tmdb
```

### Subindo o ambiente com Docker
```bash
docker-compose up -d
```

### Acessando o container da aplicação
```bash
docker exec -it laravel_app bash
```

### Instalando as dependências dentro do container laravel_app (Copie, cole e execute cada comando um de cada vez por precaução)
```bash
apt-get update && apt-get install -y unzip git zip curl
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
composer --version
composer install
docker-php-ext-install pdo_mysql
```

### Configurando o arquivo `.env`
```bash
cp .env.example .env
```

No `.env`, ajuste as variáveis de banco:
```
DB_CONNECTION=mysql
DB_HOST=laravel_mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=admin
```

### Gerando a key da aplicação
```bash
php artisan key:generate
```

### Rodando as migrations
```bash
php artisan migrate
```

### Acessando a aplicação no navegador
```
http://localhost:8000
```

### Gerando a API Key do TMDB e colocando no arquivo `.env`
* Criei uma conta no site: https://developer.themoviedb.org/reference/intro/getting-started
* Criado a conta salve a API_KEY e ACCOUNT_ID (salve em um bloco de notas), pois elas serão utilizados no arquivo `.env`
* Copie a API_KEY no link: https://www.themoviedb.org/settings/api
  - No campo Token de Leitura da API
* Cole a API_KEY na tag que está no final do arquivo `.env`, dentro das aspas duplas :
  - TMDB_API_KEY="{API_KEY}"

  Exemplo: TMDB_API_KEY="QwEtthbvOlDsx983Vx"

---

### Gerando a SESSION_ID do TMDB e colocando no arquivo `.env`
* No Google Chrome coloque vá no link: https://developer.themoviedb.org/reference/authentication-create-request-token

* Aperte no botão Try It! para gerar a REQUEST_TOKEN, copie ela

* Aba outra aba no Chrome vá no link: https://www.themoviedb.org/authenticate/{REQUEST_TOKEN}

   - Exemplo: https://www.themoviedb.org/authenticate/36c5747c80f35b1pLkmNNh79R

* Coloque no final do link a REQUEST_TOKEN gerada e entre, aperte no botao aceitar

* Após a autenticação estar concedida vá no link: https://developer.themoviedb.org/reference/authentication-create-session

* No Body Params, em RAW_BODY coloque o json: {"request_token":"{REQUEST_TOKEN}"}

   - Exemplo: {"request_token":"36c5747c80f35b1pLkmNNh79R"}

* Copie a SESSION_ID gerada e cole na chave TMDB_SESSION_ID="{SESSION_ID}" no arquivo `.env`

   - Exemplo: TMDB_SESSION_ID="552faf5465b6c582f68403c5e3d6013ooIpk"

- Para mais exemplo de como gerar a SESSION_ID entre neste link: https://www.youtube.com/watch?v=vTRgxiVH0FQ

- Após a SESSION_ID ser gerada as requisições que estão na sessão ACCOUNT no site do TMDB estarão prontas para funcionar

---

### Colocando o ACCOUNT_ID nas chaves TMDB_ENDPOINT_ADD_FAVORITE_MOVIES, TMDB_ENDPOINT_FAVORITE_MOVIES
* Pegue o ACCOUNT_ID salvo e coloque nas chaves abaixo no arquivo `.env`:
  - TMDB_ENDPOINT_ADD_FAVORITE_MOVIES="https://api.themoviedb.org/3/account/{ACCOUNT_ID}/favorite"
  - TMDB_ENDPOINT_FAVORITE_MOVIES="https://api.themoviedb.org/3/account/{ACCOUNT_ID}/favorite/movies"

  - Exemplo: TMDB_ENDPOINT_ADD_FAVORITE_MOVIES="https://api.themoviedb.org/3/account/123456/favorite"

---

### Caminhos de arquivos que fazem parte do CRUD
* No diretório src/routes - Está o arquivo contendo todas as rotas da api
* No diretório src/database/migrations - Está as migrations padrões do projeto e a create_movies_table
* No diretório src/app/Models - Está a model Movie
* No diretório src/app/Http/Controllers - Está o controller MoviesController
* No diretório src/app/Repositories - Está o repository MoviesRepository
* No diretório src/app/Service - Está a service MoviesApiService

---

## Como utilizar a API no Postman ou Insomnia

### Adicionar um filme favorito na API TMDB e salvar localmente no banco (POST `http://localhost:8000/api/movies/add-movie`)
Exemplo de JSON no Body para cadastro:
```json
{
    "media_type": "movie",
    "media_id": 1111,
    "favorite": true
}
```

Para mais exemplo de como adicionar um filme favorito na API TMDB entre neste link: https://youtu.be/431DUppjdt8?si=HCdKlNrRS-g_V7_q

### Listar filmes favoritos baseado no número de pagina (GET `http://localhost:8000/api/movies/search/favorite/movies/{currentPage}`)
Exemplo:
```
GET /api/movies/search/favorite/movies/1
```

### Listar filmes baseado no nome do filme (GET `http://localhost:8000/api/movies/search/{movie}`)
Exemplo:
```
GET /api/movies/search/batman
```

### Listar filmes baseado no número de página (GET `http://localhost:8000/api/movies/{currentPage}`)`
Exemplo:
```
GET /api/movies/1
```

### Deletar um filme localmente no banco de dados (DELETE `http://localhost:8000/api/movies/{id}`)
Exemplo:
```
DELETE /api/movies/1
```

### Listar generos (GET `http://localhost:8000/api/genres`)
Exemplo:
```
GET /api/genres
```

---

## Requisitos atendidos (conforme orientado na descrição do projeto)
- ✅ Buscar filmes pelo nome usando a API do TMDB
- ✅ Adicionar filmes aos favoritos, salvando os dados localmente
- ✅ Listar filmes favoritos em uma tela dedicada, com filtro por gênero
- ✅ Remover filmes da lista de favoritos

## Algumas resalvas dos requisitos atendidos do projeto
* A listagem de filmes favoritos com filtro por gênero não foi utilizado a filtragem por gênero
pois no site do TMDB a requisição de Favorite Movies da sessão ACCOUNT do link: https://developer.themoviedb.org/reference/account-get-favorites , não recebe o perâmetro para passar o id do gênero, nesse caso foi utilizado
o parâmetro de page para exemplificar uma filtragem.

* A remoção de filmes favoritos está sendo feito somente a deleção do filme localmente do banco
pois no site do TMDB não existe uma rota para deletar um filme favorito na sessão ACCOUNT

---

## Seguindo padrões de commits baseados do site
* https://www.conventionalcommits.org/pt-br/v1.0.0-beta.4/

---

## Repositório com o projeto front-end separado em Vue.js
* https://github.com/bruno-corral/dashboard_filmes_tmdb/

---

## Sobre mim

Projeto desenvolvido por Bruno Corral como parte do processo seletivo para Desenvolvedor(a) Full Stack Júnior.  
Focado em boas práticas, clareza de código e eficiência.

---

## Licença
Este projeto foi desenvolvido exclusivamente para fins de avaliação técnica.

