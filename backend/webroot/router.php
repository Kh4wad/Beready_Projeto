<?php

// ============================================
// CORS CONFIGURATION
// ============================================
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Pega o caminho da URL
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Arquivos estáticos - serve direto
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf)$/', $path)) {
    return false;
}

// ============================================
// API ROUTES - USERS
// ============================================

// Health check
if ($path === '/health') {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'API funcionando!',
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit();
}

// Registro de usuário
if ($path === '/auth/register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    echo json_encode([
        'success' => true,
        'message' => 'Registro simulado',
        'data' => $data,
        'user' => [
            'id' => rand(1, 1000),
            'nome' => $data['nome'] ?? '',
            'email' => $data['email'] ?? '',
            'telefone' => $data['telefone'] ?? '',
            'nivel_ingles' => $data['nivel_ingles'] ?? 'iniciante',
            'idioma_preferido' => $data['idioma_preferido'] ?? 'pt-BR',
            'status' => 'ativo',
            'objetivos_aprendizado' => $data['objetivos_aprendizado'] ?? ''
        ]
    ]);
    exit();
}

// Login de usuário
if ($path === '/auth/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    echo json_encode([
        'success' => true,
        'message' => 'Login realizado com sucesso',
        'user' => [
            'id' => 1,
            'nome' => explode('@', $data['email'] ?? 'Usuário')[0],
            'email' => $data['email'] ?? '',
            'telefone' => '(11) 99999-9999',
            'nivel_ingles' => 'intermediario',
            'idioma_preferido' => 'pt-BR',
            'status' => 'ativo',
            'objetivos_aprendizado' => 'Aprender inglês para viagens e negócios'
        ]
    ]);
    exit();
}

// Logout
if ($path === '/auth/logout' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Logout realizado com sucesso'
    ]);
    exit();
}

// Forgot Password
if ($path === '/auth/forgot-password' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    
    echo json_encode([
        'success' => true,
        'message' => 'Link de recuperação enviado para seu e-mail!',
        'reset_link' => 'http://localhost:5173/reset-password/token_simulado_' . md5(uniqid())
    ]);
    exit();
}

// Reset Password
if (preg_match('/^\/auth\/reset-password\/(.+)$/', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $token = $matches[1];
    $data = json_decode(file_get_contents('php://input'), true);
    
    echo json_encode([
        'success' => true,
        'message' => 'Senha redefinida com sucesso!'
    ]);
    exit();
}

// Buscar usuário por ID
if (preg_match('/^\/users\/(\d+)$/', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    $userId = (int)$matches[1];
    
    echo json_encode([
        'success' => true,
        'user' => [
            'id' => $userId,
            'nome' => 'Usuário Teste',
            'email' => 'usuario@email.com',
            'telefone' => '(11) 99999-9999',
            'nivel_ingles' => 'intermediario',
            'idioma_preferido' => 'pt-BR',
            'status' => 'ativo',
            'objetivos_aprendizado' => 'Aprender inglês para viagens'
        ]
    ]);
    exit();
}

// Atualizar usuário
if (preg_match('/^\/users\/(\d+)$/', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'PUT') {
    header('Content-Type: application/json');
    $userId = (int)$matches[1];
    $data = json_decode(file_get_contents('php://input'), true);
    
    echo json_encode([
        'success' => true,
        'message' => 'Perfil atualizado com sucesso',
        'user' => array_merge([
            'id' => $userId,
            'nome' => 'Usuário Teste',
            'email' => 'usuario@email.com',
            'telefone' => '(11) 99999-9999',
            'nivel_ingles' => 'intermediario',
            'idioma_preferido' => 'pt-BR',
            'status' => 'ativo',
            'objetivos_aprendizado' => 'Aprender inglês para viagens'
        ], $data)
    ]);
    exit();
}

// ============================================
// SERVE ARQUIVOS ESTÁTICOS
// ============================================

if (file_exists(__DIR__ . $path) && !is_dir(__DIR__ . $path)) {
    return false;
}

// Fallback para o CakePHP (se existir)
if (file_exists(__DIR__ . '/index_cake.php')) {
    require __DIR__ . '/index_cake.php';
} else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Rota não encontrada'
    ]);
}