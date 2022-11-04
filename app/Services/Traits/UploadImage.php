<?php

namespace App\Services\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadImage {

    /**
     * @param $image
     * @param path
     * @param $name
     * @param int $quality
     * @return false|string
     */
    public function uploadImage($image, $path, $name, $quality = 100) {
        $original_path = "/public/$path";
        $image_name = $this->createName($name);

        $contents = file_get_contents($image->getRealPath());
        $create_image = @imagecreatefromstring($contents);

        if ($create_image) {
            imagepalettetotruecolor($create_image);

            Storage::makeDirectory('temporary/');

            imagewebp($create_image, Storage::path('temporary/' . $image_name), $quality);
            $contents = file_get_contents(Storage::path('temporary/' . $image_name));

            if(Storage::disk('local')->put("$original_path/$image_name", $contents, 'public')) {
                Storage::deleteDirectory('temporary/');

                return "/storage/$path/$image_name";
            }


        }

        return false;
    }

    /**
     * @param null $name
     * @return string
     */
    public function createName($name = null): string
    {
        $time = time();

        if($name) {
            return  "$time-$name.webp";
        }

        return  "$time.webp";
    }
}
