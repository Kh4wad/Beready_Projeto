<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="register-container">
    <div class="register-card">
        <div class="card-header">
            <div class="header-icon">
                <i class="fas fa-user-edit"></i>
            </div>
            <h1 class="card-title">Editar Perfil</h1>
            <p class="card-subtitle">Atualize suas informações pessoais</p>
        </div>

        <div class="card-body">
            <!-- Flash Messages Centralizadas -->
            <div class="flash-messages-container">
                <?= $this->Flash->render() ?>
            </div>

            <?= $this->Form->create($user, ['class' => 'register-form', 'type' => 'file']) ?>
                <div class="form-grid">
                    <!-- Informações Básicas -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-user"></i>
                            Informações Pessoais
                        </h3>

                        <div class="form-group">
                            <label class="form-label">Nome Completo *</label>
                            <div class="input-container">
                                <i class="fas fa-user input-icon"></i>
                                <?= $this->Form->control('nome', [
                                    'label' => false,
                                    'placeholder' => 'Seu nome completo',
                                    'required' => true,
                                    'class' => 'form-input'
                                ]) ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">E-mail *</label>
                            <div class="input-container">
                                <i class="fas fa-envelope input-icon"></i>
                                <?= $this->Form->control('email', [
                                    'type' => 'email',
                                    'label' => false,
                                    'placeholder' => 'seu.email@exemplo.com',
                                    'required' => true,
                                    'class' => 'form-input'
                                ]) ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Telefone</label>
                            <div class="input-container">
                                <i class="fas fa-phone input-icon"></i>
                                <?= $this->Form->control('telefone', [
                                    'label' => false,
                                    'placeholder' => '(99) 99999-9999',
                                    'class' => 'form-input telefone-input',
                                    'id' => 'telefone',
                                    'maxlength' => 15
                                ]) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Segurança -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-lock"></i>
                            Segurança
                        </h3>

                        <div class="form-group">
                            <label class="form-label">Nova Senha</label>
                            <div class="input-container password-container">
                                <i class="fas fa-key input-icon"></i>
                                <?= $this->Form->control('senha', [
                                    'type' => 'password',
                                    'label' => false,
                                    'placeholder' => 'Deixe em branco para manter a senha atual',
                                    'class' => 'form-input password-input',
                                    'id' => 'password'
                                ]) ?>
                                <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                            </div>
                            <div class="password-strength">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strength-fill"></div>
                                </div>
                                <div class="strength-text" id="strength-text">Força da senha</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Confirmar Nova Senha</label>
                            <div class="input-container password-container">
                                <i class="fas fa-key input-icon"></i>
                                <?= $this->Form->control('confirmar_senha', [
                                    'type' => 'password',
                                    'label' => false,
                                    'placeholder' => 'Digite a nova senha novamente',
                                    'class' => 'form-input password-input',
                                    'id' => 'confirmPassword'
                                ]) ?>
                                <i class="fas fa-eye toggle-password" id="toggleConfirmPassword"></i>
                            </div>
                            <div class="password-match" id="passwordMatch">
                                <i class="fas fa-check-circle match-icon"></i>
                                <span class="match-text">As senhas coincidem</span>
                            </div>
                        </div>
                    </div>

                    <!-- Preferências de Aprendizado -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-graduation-cap"></i>
                            Preferências de Aprendizado
                        </h3>

                        <div class="form-group">
                            <label class="form-label">Nível de Inglês</label>
                            <div class="input-container">
                                <i class="fas fa-language input-icon"></i>
                                <?= $this->Form->control('nivel_ingles', [
                                    'label' => false,
                                    'options' => [
                                        'iniciante' => 'Iniciante',
                                        'intermediario' => 'Intermediário',
                                        'avancado' => 'Avançado'
                                    ],
                                    'empty' => 'Selecione seu nível',
                                    'class' => 'form-input select-input'
                                ]) ?>
                                <i class="fas fa-chevron-down select-arrow"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Idioma Preferido</label>
                            <div class="input-container">
                                <i class="fas fa-globe input-icon"></i>
                                <?= $this->Form->control('idioma_preferido', [
                                    'label' => false,
                                    'options' => [
                                        'pt-BR' => 'Português (Brasil)',
                                        'en' => 'Inglês',
                                        'es' => 'Espanhol'
                                    ],
                                    'empty' => 'Selecione o idioma',
                                    'class' => 'form-input select-input'
                                ]) ?>
                                <i class="fas fa-chevron-down select-arrow"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Objetivos de Aprendizado</label>
                            <div class="input-container">
                                <i class="fas fa-bullseye input-icon"></i>
                                <?= $this->Form->control('objetivos_aprendizado', [
                                    'type' => 'textarea',
                                    'label' => false,
                                    'placeholder' => 'Descreva seus objetivos...',
                                    'rows' => 3,
                                    'class' => 'form-input textarea-input'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <?= $this->Html->link('Cancelar', ['action' => 'view', $user->id], [
                        'class' => 'btn btn-secondary'
                    ]) ?>
                    <?= $this->Form->button(('Salvar Alterações'), [
                        'class' => 'btn btn-primary submit-btn',
                        'type' => 'submit'
                    ]) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<style>
/* Adicione todo o CSS do add.php aqui */
.register-container {
    padding: 20px;
    max-width: 900px;
    margin: 0 auto;
}

.register-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.card-header {
    background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
    color: white;
    padding: 40px 32px;
    text-align: center;
    position: relative;
}

.card-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #8b5cf6, #a78bfa);
}

.header-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 32px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.card-title {
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 8px 0;
    color: white;
}

.card-subtitle {
    font-size: 16px;
    opacity: 0.9;
    margin: 0;
    font-weight: 400;
    line-height: 1.5;
}

.card-body {
    padding: 40px;
}

/* Flash Messages Centralizadas */
.flash-messages-container {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    width: 90%;
    max-width: 400px;
}

.flash-messages-container .alert {
    padding: 20px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 500;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    border: none;
}

.flash-messages-container .alert-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.flash-messages-container .alert-error,
.flash-messages-container .alert-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.current-photo {
    margin-top: 10px;
    font-size: 14px;
    color: #6b7280;
    font-weight: 500;
}

/* Adicione todo o resto do CSS do add.php aqui */
.form-grid {
    display: grid;
    gap: 30px;
}

.form-section {
    background: #f8fafc;
    padding: 25px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e5e7eb;
}

/* ... resto do CSS igual ao add.php ... */
</style>

<script>
// Adicione todo o JavaScript do add.php aqui
document.addEventListener('DOMContentLoaded', function() {
    // Máscara de telefone
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length <= 11) {
                if (value.length <= 2) {
                    value = value.replace(/^(\d{0,2})/, '($1');
                } else if (value.length <= 6) {
                    value = value.replace(/^(\d{2})(\d{0,4})/, '($1) $2');
                } else if (value.length <= 10) {
                    value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                } else {
                    value = value.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
                }
                
                e.target.value = value;
            }
        });
    }

    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const strengthFill = document.getElementById('strength-fill');
    const strengthText = document.getElementById('strength-text');
    const passwordMatch = document.getElementById('passwordMatch');

    function checkPasswordStrength(password) {
        let strength = 0;
        let text = '';
        let className = '';

        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
        if (password.match(/\d/)) strength++;
        if (password.match(/[^a-zA-Z\d]/)) strength++;

        switch(strength) {
            case 0: text = 'Muito Fraca'; className = ''; break;
            case 1: text = 'Fraca'; className = 'weak'; break;
            case 2: text = 'Moderada'; className = 'medium'; break;
            case 3: text = 'Forte'; className = 'strong'; break;
            case 4: text = 'Muito Forte'; className = 'very-strong'; break;
        }

        return { text, className };
    }

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (password && confirmPassword) {
            passwordMatch.classList.add('visible');
            if (password === confirmPassword) {
                passwordMatch.classList.add('matching');
                passwordMatch.classList.remove('not-matching');
                passwordMatch.innerHTML = '<i class="fas fa-check-circle match-icon"></i><span class="match-text">As senhas coincidem</span>';
            } else {
                passwordMatch.classList.add('not-matching');
                passwordMatch.classList.remove('matching');
                passwordMatch.innerHTML = '<i class="fas fa-times-circle match-icon"></i><span class="match-text">As senhas não coincidem</span>';
            }
        } else {
            passwordMatch.classList.remove('visible');
        }
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const { text, className } = checkPasswordStrength(password);
            
            strengthFill.className = 'strength-fill ' + className;
            strengthText.textContent = `Força da senha: ${text}`;
            
            checkPasswordMatch();
        });
    }

    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    }

    // Toggle password visibility
    function setupTogglePassword(toggleElement, passwordElement) {
        if (toggleElement && passwordElement) {
            toggleElement.addEventListener('click', function() {
                const type = passwordElement.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordElement.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
    }

    setupTogglePassword(document.getElementById('togglePassword'), passwordInput);
    setupTogglePassword(document.getElementById('toggleConfirmPassword'), confirmPasswordInput);

    // File upload preview
    const fileInput = document.getElementById('fotoPerfil');
    const fileUploadArea = document.getElementById('fileUploadArea');
    const filePreview = document.getElementById('filePreview');

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.type.startsWith('image/')) {
                    if (file.size > 5 * 1024 * 1024) {
                        filePreview.innerHTML = '<p class="text-error">Arquivo muito grande. Máximo 5MB.</p>';
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        filePreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                    };
                    reader.readAsDataURL(file);
                } else {
                    filePreview.innerHTML = '<p class="text-error">Por favor, selecione uma imagem (PNG, JPG).</p>';
                }
            }
        });
    }

    // Auto-remover mensagens flash após 5 segundos
    setTimeout(function() {
        const flashMessages = document.querySelector('.flash-messages-container');
        if (flashMessages) {
            flashMessages.style.transition = 'opacity 0.5s ease';
            flashMessages.style.opacity = '0';
            setTimeout(function() {
                if (flashMessages.parentNode) {
                    flashMessages.parentNode.removeChild(flashMessages);
                }
            }, 500);
        }
    }, 5000);
});
</script>