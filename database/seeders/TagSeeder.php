<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Roman', 'Polar', 'Essai', 'Saga', 'Historique', 'Horreur',
            'Science-fiction', 'Romantique', 'Initiation', 'Fantastique',
            'Guerre', 'Familial', 'Politique', 'Biographique'
        ];

        foreach ($tags as $tagName) {
            Tag::create(['name' => $tagName]);
        }
    }
}
