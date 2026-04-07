<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        try {
            $projects = $this->projectService->getAllProjects();
            
            return response()->json([
                'data' => $projects
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao listar projetos.',
                'status' => 500
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'nullable|in:open,in_progress,completed',
                'deadline' => 'nullable|date',
            ]);

            $project = $this->projectService->createProject($validated);
            
            return response()->json([
                'data' => $project,
                'message' => 'Projeto criado com sucesso.'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Dados inválidos.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar projeto.',
                'status' => 500
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $project = $this->projectService->getProjectById($id);
            
            return response()->json([
                'data' => $project
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 404
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar projeto.',
                'status' => 500
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'status' => 'nullable|in:open,in_progress,completed',
                'deadline' => 'nullable|date',
            ]);

            $project = $this->projectService->updateProject($id, $validated);
            
            return response()->json([
                'data' => $project,
                'message' => 'Projeto atualizado com sucesso.'
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
                'message' => 'Erro ao atualizar projeto.',
                'status' => 500
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->projectService->deleteProject($id);
            
            return response()->json([
                'message' => 'Projeto removido com sucesso.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 404
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao remover projeto.',
                'status' => 500
            ], 500);
        }
    }
}
