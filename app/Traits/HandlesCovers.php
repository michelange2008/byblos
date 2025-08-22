<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HandlesCovers
{
    /**
     * Stocke une image binaire de couverture dans storage/public/covers
     * et la redimensionne si nécessaire.
     *
     * @param string $title Le titre du livre (pour générer le nom de fichier)
     * @param string $coverContents Contenu binaire de l'image
     * @param int $maxHeight Hauteur maximale (px)
     * @return string|null Chemin relatif de l'image stockée ou null si aucun contenu
     */
    public function storeCover(string $title, ?string $coverContents, int $maxHeight = 400): ?string
    {
        if (!$coverContents) {
            return null;
        }

        $image = imagecreatefromstring($coverContents);
        if ($image === false) {
            throw new \Exception("Impossible de créer l'image depuis le binaire.");
        }

        $width  = imagesx($image);
        $height = imagesy($image);

        if ($height > $maxHeight) {
            $ratio = $maxHeight / $height;
            $newWidth  = (int)($width * $ratio);
            $newHeight = $maxHeight;

            $resized = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resized;
        }

        $safeTitle = Str::slug($title);
        $coverPath = storage_path("app/public/covers/{$safeTitle}.jpg");

        if (!file_exists(dirname($coverPath))) {
            mkdir(dirname($coverPath), 0775, true);
        }

        imagejpeg($image, $coverPath, 90);
        imagedestroy($image);

        return "covers/{$safeTitle}.jpg";
    }
}
