<?php

namespace App\Traits;

use Exception;

trait ImageResizeTrait
{
    /**
     * Redimensionner une image binaire et la sauvegarder sur disque.
     * Ne dépend pas d'Intervention/Image.
     *
     * @param string $imageContents Contenu binaire de l'image
     * @param string $path Chemin complet pour sauvegarde (ex: storage_path('app/public/covers/...'))
     * @param int $maxHeight Hauteur maximale en px
     * @return void
     * @throws Exception
     */
    public function resizeAndSaveImage(string $imageContents, string $path, int $maxHeight = 400): void
    {
        $src = imagecreatefromstring($imageContents);
        if (!$src) {
            throw new Exception("Impossible de créer l'image à partir du contenu binaire.");
        }

        $width = imagesx($src);
        $height = imagesy($src);

        if ($height <= $maxHeight) {
            // Pas besoin de redimensionner
            file_put_contents($path, $imageContents);
            imagedestroy($src);
            return;
        }

        $ratio = $width / $height;
        $newHeight = $maxHeight;
        $newWidth = (int) ($maxHeight * $ratio);

        $dst = imagecreatetruecolor($newWidth, $newHeight);

        // Pour PNG et GIF : conserver la transparence
        $info = getimagesizefromstring($imageContents);
        if ($info[2] == IMAGETYPE_PNG || $info[2] == IMAGETYPE_GIF) {
            imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Déterminer le type et sauvegarder
        switch ($info[2]) {
            case IMAGETYPE_JPEG:
                imagejpeg($dst, $path, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($dst, $path, 6);
                break;
            case IMAGETYPE_GIF:
                imagegif($dst, $path);
                break;
            default:
                imagedestroy($src);
                imagedestroy($dst);
                throw new Exception("Format d'image non supporté.");
        }

        imagedestroy($src);
        imagedestroy($dst);
    }
}
