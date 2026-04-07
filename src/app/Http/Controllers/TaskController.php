<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index($projectId)
    {
        try {
            $tasks = $this->taskService->getProjectTasks($projectId);
            
            return response()->json([
                'data' => $tasks
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 404
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao listar tarefas.',
                'status' => 500
            ], 500);
        }
    }

    public function store(Request $request, $projectId)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'nullable|in:pending,in_progress,done',
                'priority' => 'nullable|in:low,medium,high',
                'due_date' => 'nullable|date',
            ]);

            $task = $this->taskService->createTask($projectId, $validated);
            
            return response()->json([
                'data' => $task,
                'message' => 'Tarefa criada com sucesso.'
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 404
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Dados inválidos.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar tarefa.',
                'status' => 500
            ], 500);
        }
    }

    public function show($projectId, $taskId)
    {
        try {
            $task = $this->taskService->getTaskById($projectId, $taskId);
            
            return response()->json([
                'data' => $task
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 404
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar tarefa.',
                'status' => 500
            ], 500);
        }
    }

    public function update(Request $request, $projectId, $taskId)
    {
        try {
            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'status' => 'nullable|in:pending,in_progress,done',
                'priority' => 'nullable|in:low,medium,high',
                'due_date' => 'nullable|date',
            ]);

            $task = $this->taskService->updateTask($projectId, $taskId, $validated);
            
            return response()->json([
                'data' => $task,
                'message' => 'Tarefa atualizada com sucesso.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 404
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Dados inválidos.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar tarefa.',
                'status' => 500
            ], 500);
        }
    }

    public function updateStatus(Request $request, $projectId, $taskId)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,in_progress,done',
            ]);

            $task = $this->taskService->updateTaskStatus($projectId, $taskId, $validated['status']);
            
            return response()->json([
                'data' => $task,
                'message' => 'Status da tarefa atualizado com sucesso.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 404
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Dados inválidos.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar status da tarefa.',
                'status' => 500
            ], 500);
        }
    }

    public function destroy($projectId, $taskId)
    {
        try {
            $this->taskService->deleteTask($projectId, $taskId);
            
            return response()->json([
                'message' => 'Tarefa removida com sucesso.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 404
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao remover tarefa.',
                'status' => 500
            ], 500);
        }
    }

    public function attachTag($taskId, $tagId)
    {
        try {
            $task = $this->taskService->attachTag($taskId, $tagId);
            
            return response()->json([
                'data' => $task,
                'message' => 'Tag associada à tarefa com sucesso.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 404
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao associar tag.',
                'status' => 500
            ], 500);
        }
    }

    public function detachTag($taskId, $tagId)
    {
        try {
            $task = $this->taskService->detachTag($taskId, $tagId);
            
            return response()->json([
                'data' => $task,
                'message' => 'Tag removida da tarefa com sucesso.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 404
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao remover tag.',
                'status' => 500
            ], 500);
        }
    }
}