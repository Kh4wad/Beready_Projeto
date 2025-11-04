<?php
/**
 * Layout padrão personalizado Beready
 * Substitui o default do CakePHP
 * @var \App\View\AppView $this
 */

// Verifica se há usuário na sessão (método alternativo)
$isLoggedIn = isset($_SESSION['Auth']) && !empty($_SESSION['Auth']['id']);
$username = $isLoggedIn ? ($_SESSION['Auth']['username'] ?? $_SESSION['Auth']['email'] ?? 'Usuário') : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') ?: 'Beready - Sistema de Flashcards' ?></title>
    <?= $this->Html->meta('icon') ?>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS customizado -->
    <style>
        :root {
            --primary-color: #d81b60;
            --secondary-color: #6c757d;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --border-color: #dee2e6;
        }

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }

        html, body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            height: 100%; 
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .main-header {
            background: linear-gradient(135deg, var(--primary-color), #c2185b);
            color: white;
            padding: 1rem 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            position: relative;
            z-index: 1000;
            flex-shrink: 0;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo { 
            display: flex; 
            align-items: center; 
            gap: 15px; 
            text-decoration: none;
        }
        .logo:hover {
            opacity: 0.9;
        }
        .logo-icon { 
            font-size: 2rem; 
            color: white; 
        }
        .logo-text { 
            font-size: 1.8rem; 
            font-weight: 700; 
            letter-spacing: -0.5px; 
            color: white;
        }

        .nav-links { 
            display: flex; 
            gap: 25px; 
            align-items: center;
        }
        .nav-links a { 
            color: white; 
            text-decoration: none; 
            font-weight: 500; 
            transition: opacity 0.3s; 
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .nav-links a:hover { 
            opacity: 0.8; 
        }

        .user-menu {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .user-info {
            font-size: 0.9rem;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Main content */
        main.main { 
            flex: 1; 
            padding: 20px; 
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Container para garantir que o conteúdo principal ocupe o espaço disponível */
        .page-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Footer */
        .main-footer {
            background: var(--dark-color);
            color: white;
            width: 100%;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1rem;
            flex-shrink: 0;
            margin-top: auto;
        }

        /* Alertas customizados */
        .alert-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        @media (max-width: 768px) {
            .header-content { 
                flex-direction: column; 
                gap: 15px; 
                text-align: center;
            }
            .nav-links { 
                gap: 15px; 
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .user-menu {
                flex-direction: column;
                gap: 10px;
            }
            
            main.main {
                padding: 15px;
            }
            
            .logo-text {
                font-size: 1.5rem;
            }
            
            .logo-icon {
                font-size: 1.7rem;
            }
        }

        @media (max-width: 480px) {
            .main-header {
                padding: 0.8rem 15px;
            }
            
            .nav-links {
                gap: 10px;
            }
            
            .nav-links a {
                font-size: 0.9rem;
            }
            
            .main-footer {
                padding: 15px;
                font-size: 0.9rem;
                text-align: center;
            }
        }
    </style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <div class="page-container">
        <!-- Header -->
        <header class="main-header">
            <div class="header-content">
                <a href="<?= $this->Url->build('/') ?>" class="logo">
                    <i class="fas fa-graduation-cap logo-icon"></i>
                    <span class="logo-text">Beready</span>
                </a>
                
                <nav class="nav-links">
                    <?php if ($isLoggedIn): ?>
                        <!-- Menu para usuários logados -->
                        <a href="<?= $this->Url->build('/flashcards') ?>">
                            <i class="fas fa-cards"></i> Flashcards
                        </a>
                        <a href="<?= $this->Url->build('/tags') ?>">
                            <i class="fas fa-tags"></i> Tags
                        </a>
                        <a href="<?= $this->Url->build('/users') ?>">
                            <i class="fas fa-users"></i> Usuários
                        </a>
                        
                        <div class="user-menu">
                            <span class="user-info">
                                <i class="fas fa-user"></i> 
                                <?= h($username) ?>
                            </span>
                            <a href="<?= $this->Url->build('/profile') ?>">
                                <i class="fas fa-edit"></i> Perfil
                            </a>
                            <a href="<?= $this->Url->build('/logout') ?>">
                                <i class="fas fa-sign-out-alt"></i> Sair
                            </a>
                        </div>
                    <?php else: ?>
                        <!-- Menu para usuários não logados -->
                        <a href="<?= $this->Url->build('/') ?>">
                            <i class="fas fa-home"></i> Início
                        </a>
                        <a href="<?= $this->Url->build('/login') ?>">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="<?= $this->Url->build('/register') ?>">
                            <i class="fas fa-user-plus"></i> Cadastrar
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        </header>

        <!-- Alertas -->
        <div class="alert-container">
            <?= $this->Flash->render() ?>
        </div>

        <!-- Conteúdo principal -->
        <main class="main">
            <?= $this->fetch('content') ?>
        </main>

        <!-- Footer -->
        <footer class="main-footer">
            &copy; <?= date('Y') ?> Beready - Sistema de Flashcards. Todos os direitos reservados.
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>