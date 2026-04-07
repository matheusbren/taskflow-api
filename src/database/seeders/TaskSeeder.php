<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();
        $tags = Tag::all();

        foreach ($projects as $project) {
            // Tarefa 1
            $task1 = Task::firstOrCreate(
                [
                    'project_id' => $project->id,
                    'title' => 'Planejar arquitetura'
                ],
                [
                    'description' => 'Definir arquitetura do sistema',
                    'status' => 'done',
                    'priority' => 'high',
                    'due_date' => now()->addDays(5),
                ]
            );

            // Tarefa 2
            $task2 = Task::firstOrCreate(
                [
                    'project_id' => $project->id,
                    'title' => 'Desenvolver funcionalidades'
                ],
                [
                    'description' => 'Implementar CRUD completo',
                    'status' => 'in_progress',
                    'priority' => 'high',
                    'due_date' => now()->addDays(15),
                ]
            );

            // Tarefa 3
            $task3 = Task::firstOrCreate(
                [
                    'project_id' => $project->id,
                    'title' => 'Realizar testes'
                ],
                [
                    'description' => 'Testes unitários e integração',
                    'status' => 'pending',
                    'priority' => 'medium',
                    'due_date' => now()->addDays(25),
                ]
            );

            // Associar tags (apenas se não tiver tags associadas)
            if ($task1->tags()->count() == 0) {
                $task1->tags()->attach($tags->random(2)->pluck('id')->toArray());
            }
            
            if ($task2->tags()->count() == 0) {
                $task2->tags()->attach($tags->random(2)->pluck('id')->toArray());
            }
            
            if ($task3->tags()->count() == 0) {
                $task3->tags()->attach($tags->random(1)->pluck('id')->toArray());
            }
        }
    }
}
