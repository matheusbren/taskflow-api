<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // Usar firstOrCreate para evitar duplicatas
            Project::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'name' => 'Sistema de Gestão Empresarial'
                ],
                [
                    'description' => 'Sistema completo para gestão de empresas',
                    'status' => 'in_progress',
                    'deadline' => now()->addDays(45),
                ]
            );

            Project::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'name' => 'E-commerce Moderno'
                ],
                [
                    'description' => 'Loja virtual com carrinho de compras',
                    'status' => 'open',
                    'deadline' => now()->addDays(60),
                ]
            );

            Project::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'name' => 'Aplicativo Mobile'
                ],
                [
                    'description' => 'App para gestão de tarefas',
                    'status' => 'completed',
                    'deadline' => now()->subDays(10),
                ]
            );
        }
    }
}