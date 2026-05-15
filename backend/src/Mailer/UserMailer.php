<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;

class UserMailer extends Mailer
{
    public function resetPassword($user, string $token)
    {
        $resetLink = env('APP_BASE_URL', 'http://localhost:5173') . '/reset-password/' . $token;
        $this->setTransport('default')
            ->setFrom(['noreply@beready.com' => 'BeReady'])
            ->setTo($user->email)
            ->setSubject('Recuperação de Senha - BeReady')
            ->setEmailFormat('html')
            ->setViewVars([
                'nome' => $user->nome,
                'resetLink' => $resetLink,
                'expires' => date('d/m/Y H:i', strtotime('+1 hour'))
            ])
            ->setTemplate('reset_password');
    }
}