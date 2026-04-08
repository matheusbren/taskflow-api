# TaskFlow API

Repositório do projeto TaskFlow API.

## Estrutura

- [compose.yaml](compose.yaml): orquestração Docker (serviços `php` e `mysql`)
- [dockerfile](dockerfile): imagem PHP da aplicação
- [src](src): código Laravel da API

## Documentação

- Guia da aplicação Laravel: [src/README.md](src/README.md)
- Documentação da API: [src/docs/API.md](src/docs/API.md)
- Swagger UI (com app rodando): http://localhost:8000/docs/index.html
- OpenAPI YAML (com app rodando): http://localhost:8000/docs/openapi.yaml

## Subir projeto (Docker)

```bash
docker compose up -d --build
docker compose exec php php artisan key:generate
docker compose exec php php artisan migrate
```
