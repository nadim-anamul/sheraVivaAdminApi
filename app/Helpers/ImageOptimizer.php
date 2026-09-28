<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class ImageOptimizer
{
    /**
     * Optimize an image file on disk using PHP GD extension.
     * Resizes if larger than max dimensions, compresses quality, and converts to WebP.
     * 
     * @param string $fullPath Path to source file
     * @param int $maxWidth Max width constraint
     * @param int $maxHeight Max height constraint
     * @param int $quality Compression quality (1-100)
     * @return string Path to optimized file (which may end in .webp)
     */
    public static function optimizeAndConvertToWebp(string $fullPath, int $maxWidth = 600, int $maxHeight = 600, int $quality = 85): string
    {
        if (!file_exists($fullPath)) {
            return $fullPath;
        }

        $imageInfo = @getimagesize($fullPath);
        if (!$imageInfo) {
            return $fullPath;
        }

        [$width, $height, $type] = $imageInfo;

        $sourceImage = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($fullPath),
            IMAGETYPE_PNG  => @imagecreatefrompng($fullPath),
            IMAGETYPE_WEBP => @imagecreatefromwebp($fullPath),
            IMAGETYPE_GIF  => @imagecreatefromgif($fullPath),
            default        => null,
        };

        if (!$sourceImage) {
            return $fullPath;
        }

        // Calculate aspect ratio scaling
        $newWidth = $width;
        $newHeight = $height;

        if ($width > $maxWidth || $height > $maxHeight) {
            $ratio = min($maxWidth / $width, $maxHeight / $height);
            $newWidth = max(1, (int) round($width * $ratio));
            $newHeight = max(1, (int) round($height * $ratio));
        }

        // Create new truecolor canvas
        $canvas = imagecreatetruecolor($newWidth, $newHeight);

        // Handle transparency
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
        imagefill($canvas, 0, 0, $transparent);

        imagecopyresampled($canvas, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Determine destination path (.webp extension)
        $pathInfo = pathinfo($fullPath);
        $webpPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';

        if (function_exists('imagewebp')) {
            imagewebp($canvas, $webpPath, $quality);
            
            // Delete original file if we converted extension from jpg/png to webp
            if ($webpPath !== $fullPath && file_exists($webpPath) && filesize($webpPath) > 0) {
                @unlink($fullPath);
                imagedestroy($sourceImage);
                imagedestroy($canvas);
                return $webpPath;
            }
        } else {
            imagejpeg($canvas, $fullPath, $quality);
        }

        imagedestroy($sourceImage);
        imagedestroy($canvas);

        return $fullPath;
    }
}
