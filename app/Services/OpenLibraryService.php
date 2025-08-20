<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OpenLibraryService
{
    /**
     * Récupère l'image de couverture depuis Open Library (binaire)
     *
     * @param  string $title
     * @param  string $author
     * @return string|null   Contenu binaire de l'image ou null si pas trouvé
     */
    public function fetchCover(string $title, string $author): ?string
    {
        // Normalisation du titre
        $cleanTitle = Str::of($title)
            ->ascii()
            ->replaceMatches('/[^A-Za-z0-9 ]/', '')
            ->trim();

        $query = http_build_query([
            'title'  => $cleanTitle,
            'author' => $author,
        ]);

        $response = Http::get("https://openlibrary.org/search.json?$query");

        if (! $response->ok() || empty($response['docs'])) {
            return null;
        }

        $coverId = $response['docs'][0]['cover_i'] ?? null;
        if (! $coverId) {
            return null;
        }

        $coverUrl = "https://covers.openlibrary.org/b/id/{$coverId}-L.jpg";
        $coverRes = Http::get($coverUrl);

        return $coverRes->ok() ? $coverRes->body() : null;
    }
}
