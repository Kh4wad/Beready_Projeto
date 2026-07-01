<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\CloudinaryService;

class UploadController extends AppController
{
    public function profilePhoto()
    {
        $this->request->allowMethod(['post']);

        $file = $this->request->getUploadedFile('photo');

        if (!$file) {
            $this->set([
                'success' => false,
                'message' => 'Nenhuma imagem enviada.',
                '_serialize' => ['success','message']
            ]);
            return;
        }

        $service = new CloudinaryService();

        $url = $service->uploadProfilePhoto([
            'tmp_name' => $file->getStream()->getMetadata('uri')
        ]);

        $this->set([
            'success' => true,
            'url' => $url,
            '_serialize' => ['success','url']
        ]);
    }
}