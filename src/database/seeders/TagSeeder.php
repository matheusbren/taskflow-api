<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Urgente', 'color' => '#FF0000'],
            ['name' => 'Importante', 'color' => '#FFA500'],
            ['name' => 'Backend', 'color' => '#00FF00'],
            ['name' => 'Frontend', 'color' => '#0000FF'],
            ['name' => 'Design', 'color' => '#FF00FF'],
            ['name' => 'Documentação', 'color' => '#800080'],
            ['name' => 'Bug', 'color' => '#FF0000'],
            ['name' => 'Feature', 'color' => '#00FF00'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['name' => $tag['name']],
                ['color' => $tag['color']]
            );
        }
    }
}