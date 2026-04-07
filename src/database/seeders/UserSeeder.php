<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar se já existe antes de criar
        $user1 = User::firstOrCreate(
            ['email' => 'joao@example.com'],
            [
                'name' => 'João Silva',
                'password' => Hash::make('password123'),
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'maria@example.com'],
            [
                'name' => 'Maria Santos',
                'password' => Hash::make('password123'),
            ]
        );

        // Criar perfis (usando updateOrCreate para evitar duplicatas)
        $user1->profile()->updateOrCreate(
            ['user_id' => $user1->id],
            [
                'bio' => 'Desenvolvedor Full Stack',
                'phone' => '(11) 99999-1111',
                'avatar_url' => 'https://randomuser.me/api/portraits/men/1.jpg',
            ]
        );

        $user2->profile()->updateOrCreate(
            ['user_id' => $user2->id],
            [
                'bio' => 'Product Manager',
                'phone' => '(11) 99999-2222',
                'avatar_url' => 'https://randomuser.me/api/portraits/women/1.jpg',
            ]
        );
    }
}