<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectService
{
    public function getAllProjects(): Collection
    {
        return Project::with(['user', 'tasks'])
            ->withCount('tasks')
            ->get();
    }

    public function getProjectById(int $id): Project
    {
        $project = Project::with(['user', 'tasks.tags'])
            ->withCount('tasks')
            ->find($id);

        if (!$project) {
            throw new ModelNotFoundException('Projeto não encontrado.');
        }

        return $project;
    }

    public function createProject(array $data): Project
    {
        return Project::create($data);
    }

    public function updateProject(int $id, array $data): Project
    {
        $project = $this->getProjectById($id);
        $project->update($data);
        
        return $project->fresh();
    }

    public function deleteProject(int $id): bool
    {
        $project = $this->getProjectById($id);
        return $project->delete();
    }
}
