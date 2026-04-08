# TaskFlow API

## Swagger (OpenAPI)

- Interface Swagger UI: http://localhost:8000/docs/index.html
- Especificação OpenAPI YAML: http://localhost:8000/docs/openapi.yaml

## Base URL

`http://localhost:8000/api`

## Endpoints

### Projects

- `GET /projects` - Lista projetos
- `POST /projects` - Cria projeto
- `GET /projects/{id}` - Busca projeto
- `PUT /projects/{id}` - Atualiza projeto
- `DELETE /projects/{id}` - Remove projeto

### Tasks

- `GET /projects/{id}/tasks` - Lista tarefas do projeto
- `POST /projects/{id}/tasks` - Cria tarefa no projeto
- `GET /projects/{id}/tasks/{taskId}` - Busca tarefa no projeto
- `PUT /projects/{id}/tasks/{taskId}` - Atualiza tarefa
- `PATCH /projects/{id}/tasks/{taskId}/status` - Atualiza status da tarefa
- `DELETE /projects/{id}/tasks/{taskId}` - Remove tarefa

### Tags

- `GET /tags` - Lista tags
- `POST /tags` - Cria tag
- `POST /tasks/{taskId}/tags/{tagId}` - Associa tag à tarefa
- `DELETE /tasks/{taskId}/tags/{tagId}` - Remove associação de tag

### Profiles

- `GET /users/{id}/profile` - Busca perfil do usuário
- `PUT /users/{id}/profile` - Cria/atualiza perfil

## Formato de resposta

### Sucesso

```json
{
    "data": {},
    "message": "..."
}
```

### Erro comum

```json
{
    "message": "...",
    "status": 500
}
```

### Erro de validação

```json
{
    "message": "Dados inválidos.",
    "errors": {
        "campo": ["mensagem"]
    }
}
```

## Observações

- O `Try it out` já está habilitado no Swagger UI.
- Os enums e validações detalhadas estão na especificação OpenAPI.
