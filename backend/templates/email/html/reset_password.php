<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recuperação de Senha - BeReady</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-top: none; border-radius: 0 0 8px 8px; }
        .button { display: inline-block; background: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; margin: 20px 0; font-weight: bold; }
        .button:hover { background: #2563eb; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #64748b; }
        .warning { color: #ef4444; font-size: 12px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>BeReady</h1>
            <p>Recuperação de Senha</p>
        </div>
        <div class="content">
            <p>Olá, <strong><?= $nome ?></strong>!</p>
            <p>Recebemos uma solicitação para redefinir sua senha. Clique no botão abaixo para criar uma nova senha:</p>
            <div style="text-align: center;">
                <a href="http://localhost:5173/reset-password/<?= $token ?>" class="button">Redefinir Senha</a>
            </div>
            <p>Se você não solicitou esta alteração, ignore este e-mail.</p>
            <p class="warning"><strong>⚠️ Este link expira em <?= $expires ?>.</strong></p>
        </div>
        <div class="footer">
            <p>&copy; <?= date('Y') ?> BeReady. Todos os direitos reservados.</p>
            <p>Este é um e-mail automático, por favor não responda.</p>
        </div>
    </div>
</body>
</html>
