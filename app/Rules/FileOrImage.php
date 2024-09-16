<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileOrImage implements Rule
{
    public function passes($attribute, $value)
    {
        $mimetypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/bmp',
            'image/webp',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'text/plain',
        ];

        
        // Check if the value is a valid file
        if (is_uploaded_file($value) || is_string($value)) {
            return true;
        }
        // Check if the value is a valid image
        if ($value->isValid() && in_array($value->getMimeType(), $mimetypes)) {
            return true;
        }

        return false;
    }

    public function message()
    {
        return 'The :attribute must be either a file or an image.';
    }
}
