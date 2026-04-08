# TaskFlow API

API REST para gerenciamento de projetos, tarefas, tags e perfil de usuário, construída com Laravel 12.

## Estado atual do projeto

- API funcional com rotas CRUD para `projects`, `tasks`, `tags` e `profile`.
- Sem autenticação/autorização nas rotas no estado atual.
- Documentação OpenAPI/Swagger disponível localmente.

## Stack

- PHP 8.2+
- Laravel 12
- MySQL
- Docker + Docker Compose

## Como subir com Docker

No diretório raiz do repositório (onde está o [compose.yaml](../compose.yaml)):

```bash
docker compose up -d --build
docker compose exec php php artisan key:generate
docker compose exec php php artisan migrate
```

API em: `http://localhost:8000/api`

## Configuração de banco (`DB_HOST`)

Este projeto pode rodar de duas formas, e o `DB_HOST` muda conforme o contexto:

- Rodando comandos **dentro do container `php`**: usar `DB_HOST=mysql`.
- Rodando comandos **no host (fora do container)**: usar `DB_HOST=127.0.0.1`.

Arquivo: [.env](.env)

## Documentação da API

- Swagger UI: `http://localhost:8000/docs/index.html`
- OpenAPI YAML: `http://localhost:8000/docs/openapi.yaml`
- Resumo em Markdown: [docs/API.md](docs/API.md)

## Rotas disponíveis

- `GET|POST /api/projects`
- `GET|PUT|DELETE /api/projects/{id}`
- `GET|POST /api/projects/{id}/tasks`
- `GET|PUT|DELETE /api/projects/{id}/tasks/{taskId}`
- `PATCH /api/projects/{id}/tasks/{taskId}/status`
- `GET|POST /api/tags`
- `POST|DELETE /api/tasks/{taskId}/tags/{tagId}`
- `GET|PUT /api/users/{id}/profile`

## Testes

```bash
php artisan test
```

## Licença

Projeto sob licença MIT.
