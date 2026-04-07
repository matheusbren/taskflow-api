<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagService
{
    public function getAllTags(): Collection
    {
        return Tag::withCount('tasks')->get();
    }

    public function createTag(array $data): Tag
    {
        return Tag::create($data);
    }
}
