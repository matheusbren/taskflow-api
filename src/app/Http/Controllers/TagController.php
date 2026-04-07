<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index()
    {
        try {
            $tags = $this->tagService->getAllTags();
            
            return response()->json([
                'data' => $tags
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao listar tags.',
                'status' => 500
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|unique:tags,name|max:255',
                'color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            ]);

            $tag = $this->tagService->createTag($validated);
            
            return response()->json([
                'data' => $tag,
                'message' => 'Tag criada com sucesso.'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Dados inválidos.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar tag.',
                'status' => 500
            ], 500);
        }
    }
}