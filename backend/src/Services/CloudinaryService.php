<?php
declare(strict_types=1);

namespace App\Services;

use App\Contracts\CloudinaryServiceInterface;
use Cloudinary\Cloudinary;

class CloudinaryService implements CloudinaryServiceInterface
{
    private Cloudinary $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true
            ]
        ]);
    }

    public function uploadProfilePhoto(array $file): string
    {
        $result = $this->cloudinary
            ->uploadApi()
            ->upload(
                $file['tmp_name'],
                [
                    'folder' => 'beready/profile'
                ]
            );

        return $result['secure_url'];
    }
}