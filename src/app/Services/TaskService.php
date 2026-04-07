<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskService
{
    public function getProjectTasks(int $projectId): Collection
    {
        $project = Project::find($projectId);
        
        if (!$project) {
            throw new ModelNotFoundException('Projeto não encontrado.');
        }
        
        return $project->tasks()->with('tags')->get();
    }

    public function getTaskById(int $projectId, int $taskId): Task
    {
        $task = Task::with(['project', 'tags'])
            ->where('project_id', $projectId)
            ->find($taskId);

        if (!$task) {
            throw new ModelNotFoundException('Tarefa não encontrada neste projeto.');
        }

        return $task;
    }

    public function createTask(int $projectId, array $data): Task
    {
        $project = Project::find($projectId);
        
        if (!$project) {
            throw new ModelNotFoundException('Projeto não encontrado.');
        }
        
        $data['project_id'] = $projectId;
        
        return Task::create($data);
    }

    public function updateTask(int $projectId, int $taskId, array $data): Task
    {
        $task = $this->getTaskById($projectId, $taskId);
        $task->update($data);
        
        return $task->fresh();
    }

    public function updateTaskStatus(int $projectId, int $taskId, string $status): Task
    {
        $task = $this->getTaskById($projectId, $taskId);
        $task->status = $status;
        $task->save();
        
        return $task->fresh();
    }

    public function deleteTask(int $projectId, int $taskId): bool
    {
        $task = $this->getTaskById($projectId, $taskId);
        return $task->delete();
    }

    public function attachTag(int $taskId, int $tagId): Task
    {
        $task = Task::find($taskId);
        
        if (!$task) {
            throw new ModelNotFoundException('Tarefa não encontrada.');
        }
        
        if (!$task->tags()->where('tag_id', $tagId)->exists()) {
            $task->tags()->attach($tagId);
        }
        
        return $task->load('tags');
    }

    public function detachTag(int $taskId, int $tagId): Task
    {
        $task = Task::find($taskId);
        
        if (!$task) {
            throw new ModelNotFoundException('Tarefa não encontrada.');
        }
        
        $task->tags()->detach($tagId);
        
        return $task->load('tags');
    }
}
