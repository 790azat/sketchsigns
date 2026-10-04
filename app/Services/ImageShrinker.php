<?php

namespace App\Services;

/**
 * Scales big photos down before they go to Blob storage, keeping the original format
 * (and so the same file name). Anything GD can't read is passed through untouched.
 */
class ImageShrinker
{
    public function __construct(private int $maxSide = 1200, private int $quality = 80) {}

    public function shrink(string $contents, string $type): string
    {
        if (! function_exists('imagecreatefromstring') || ! in_array($type, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return $contents;
        }

        $image = @imagecreatefromstring($contents);
        if (! $image) {
            return $contents;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $scale = min(1, $this->maxSide / max($width, $height));

        if ($scale < 1) {
            $resized = imagescale($image, (int) round($width * $scale), (int) round($height * $scale), IMG_BICUBIC);
            imagedestroy($image);
            $image = $resized;
        }

        imagealphablending($image, false);
        imagesavealpha($image, true);

        ob_start();
        match ($type) {
            'image/jpeg' => imagejpeg($image, null, $this->quality),
            'image/png' => imagepng($image, null, 9),
            'image/webp' => imagewebp($image, null, $this->quality),
        };
        $output = ob_get_clean();
        imagedestroy($image);

        return $output !== '' && strlen($output) < strlen($contents) ? $output : $contents;
    }
}
