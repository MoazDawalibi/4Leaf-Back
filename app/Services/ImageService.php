<?php

namespace App\Services;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public static function upload_image(UploadedFile $new_image, $upload_location = '')
    {
        // Get the base URL from config
        $base_url = config('app.base_url'); // or config('image.base_url') if using a custom file

        // Define the folder structure
        $relative_path = 'storage/' . $upload_location . '/';
        $image_name = Str::uuid() . '.' . $new_image->getClientOriginalExtension();

        // Store the image in the public disk
        $new_image->storeAs($upload_location, $image_name, 'public');

        // Generate the full URL
        return $base_url . '/' . $relative_path . $image_name;
    }

    public static function update_image(UploadedFile $new_image, $old_image_url, $upload_location = '')
    {
        // Get the base URL from config
        $base_url = config('app.base_url'); // or config('image.base_url')

        // Delete the old image if it exists
        if (!empty($old_image_url)) {
            $relative_old_path = str_replace($base_url . '/storage/', '', $old_image_url);
            Storage::disk('public')->delete($relative_old_path);
        }

        // Upload the new image
        return self::upload_image($new_image, $upload_location);
    }

    public static function delete_image($image_url)
    {
        try {
            // Get the base URL from config
            $base_url = config('app.base_url'); // or config('image.base_url')

            $relative_path = str_replace($base_url . '/storage/', '', $image_url);
            Storage::disk('public')->delete($relative_path);

            return true;
        } catch (Exception $e) {
            return $e;
        }
    }
}
