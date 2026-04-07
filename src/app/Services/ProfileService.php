<?php

namespace App\Services;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProfileService
{
    public function getProfile(int $userId): Profile
    {
        $user = User::with('profile')->find($userId);
        
        if (!$user) {
            throw new ModelNotFoundException('Usuário não encontrado.');
        }
        
        if (!$user->profile) {
            throw new ModelNotFoundException('Perfil não encontrado para este usuário.');
        }
        
        return $user->profile;
    }

    public function createOrUpdateProfile(int $userId, array $data): Profile
    {
        $user = User::find($userId);
        
        if (!$user) {
            throw new ModelNotFoundException('Usuário não encontrado.');
        }
        
        return Profile::updateOrCreate(
            ['user_id' => $userId],
            $data
        );
    }
}
