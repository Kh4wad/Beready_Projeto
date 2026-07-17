<?php

declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;

use function Cake\Core\env;

class UserMailer extends Mailer
{
    public function resetPassword($user, string $token): void
    {
        $frontendUrl = env('APP_BASE_URL');
        $resetLink = $frontendUrl . 'reset-password/' . $token;

        $this->setTransport('default')
            ->setFrom([env('EMAIL_FROM') => env('EMAIL_FROM_NAME')])
            ->setTo($user->email)
            ->setSubject('Recuperação de Senha - BeReady')
            ->setEmailFormat('html')
            ->viewBuilder()
                ->setTemplate('reset_password')
                ->setVars([
                    'nome' => $user->nome,
                    'resetLink' => $resetLink,
                    'expires' => date('d/m/Y H:i', strtotime('+1 hour'))
                ]);
        
        $this->deliver();
    }
}