<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show($userId)
    {
        try {
            $profile = $this->profileService->getProfile($userId);
            
            return response()->json([
                'data' => $profile
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 404
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar perfil.',
                'status' => 500
            ], 500);
        }
    }

    public function update(Request $request, $userId)
    {
        try {
            $validated = $request->validate([
                'bio' => 'nullable|string',
                'phone' => 'nullable|string|max:20',
                'avatar_url' => 'nullable|url|max:255',
            ]);

            $profile = $this->profileService->createOrUpdateProfile($userId, $validated);
            
            $message = $profile->wasRecentlyCreated ? 
                'Perfil criado com sucesso.' : 
                'Perfil atualizado com sucesso.';
            
            return response()->json([
                'data' => $profile,
                'message' => $message
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
                'message' => 'Erro ao processar perfil.',
                'status' => 500
            ], 500);
        }
    }
}