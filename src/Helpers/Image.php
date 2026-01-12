<?php

namespace Application\Helpers;

use Application\Core\Factory;
use CoffeeCode\Uploader\Image as UploaderImage;

class Image
{
    public static function upload(array $file, string $name, string $folder): ?string
    {
        $name = strtolower($name) . date('YmdHis');
        $uploader = Factory::create(UploaderImage::class, ['../assets/images', $folder]);
        // $uploader = new UploaderImage('../../assets/images', $folder);
        $uploadedImage = $uploader->upload($file, $name);

        return $uploadedImage ?: null;
    }
}
