<?php
/**
 * Layout padrão personalizado Beready
 * Substitui o default do CakePHP
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') ?: 'Beready' ?></title>
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

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body, html { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; height: 100%; width: 100%; }

        /* Header */
        .main-header {
            background: linear-gradient(135deg, var(--primary-color), #c2185b);
            color: white;
            padding: 1rem 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin: 0;
        }

        .logo { display: flex; align-items: center; gap: 15px; }
        .logo-icon { font-size: 2rem; color: white; }
        .logo-text { font-size: 1.8rem; font-weight: 700; letter-spacing: -0.5px; }

        .nav-links { display: flex; gap: 25px; }
        .nav-links a { color: white; text-decoration: none; font-weight: 500; transition: opacity 0.3s; }
        .nav-links a:hover { opacity: 0.8; }

        /* Main content */
        main.main { flex: 1; padding: 20px; min-height: calc(100vh - 100px); }

        /* Footer */
        .main-footer {
            background: var(--dark-color);
            color: white;
            width: 100%;
            height: 80px; /* altura do footer */
            display: flex;
            justify-content: center; /* centraliza horizontal */
            align-items: center;    /* centraliza vertical */
            font-size: 1.2rem;      /* aumenta o tamanho do texto */
        }

        @media (max-width: 768px) {
            .header-content { flex-direction: column; gap: 15px; }
            .nav-links { gap: 15px; }
        }
    </style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <!-- Header -->
    <hea
    r class="main-header">
        <div class="header-content">
            <div class="logo">
                <i class="fas fa-graduation-cap logo-icon"></i>
                <span class="logo-text">Beready</span>
            </div>
            <nav class="nav-links">
                <a href="#">Início</a>
                <a href="#">Sobre</a>
                <a href="#">Contato</a>
                <a href="#">Ajuda</a>
            </nav>
        </div>
    </header>

    <!-- Conteúdo principal -->
    <main class="main">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        &copy; <?= date('Y') ?> Beready. Todos os direitos reservados.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>