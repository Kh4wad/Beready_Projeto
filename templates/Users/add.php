<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Usuario $usuario
 */
?>
<div class="register-container">
    <div class="register-card">
        <div class="card-header">
            <div class="header-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1 class="card-title">Criar Conta</h1>
            <p class="card-subtitle">Junte-se à nossa comunidade de aprendizado</p>
        </div>

        <div class="card-body">
            <?= $this->Form->create($usuario, ['class' => 'register-form']) ?>
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
                                    'placeholder' => '(11) 99999-9999',
                                    'class' => 'form-input'
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
                            <label class="form-label">Senha *</label>
                            <div class="input-container">
                                <i class="fas fa-key input-icon"></i>
                                <?= $this->Form->control('senha_hash', [
                                    'type' => 'password',
                                    'label' => false,
                                    'placeholder' => 'Crie uma senha segura',
                                    'required' => true,
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
                                        'Iniciante' => 'Iniciante',
                                        'Básico' => 'Básico',
                                        'Intermediário' => 'Intermediário',
                                        'Avançado' => 'Avançado',
                                        'Fluente' => 'Fluente'
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
                                        'Português' => 'Português',
                                        'Inglês' => 'Inglês',
                                        'Espanhol' => 'Espanhol',
                                        'Francês' => 'Francês'
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

                    <!-- Foto de Perfil -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-camera"></i>
                            Foto de Perfil
                        </h3>

                        <div class="form-group">
                            <label class="form-label">Upload da Foto</label>
                            <div class="file-upload-container">
                                <div class="file-upload-area" id="fileUploadArea">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <p class="upload-text">Clique para selecionar ou arraste uma foto</p>
                                    <p class="upload-hint">PNG, JPG até 5MB</p>
                                </div>
                                <?= $this->Form->control('foto_perfil', [
                                    'type' => 'file',
                                    'label' => false,
                                    'class' => 'file-input',
                                    'id' => 'fotoPerfil'
                                ]) ?>
                                <div class="file-preview" id="filePreview"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Campos ocultos para valores padrão -->
                <?= $this->Form->control('status', [
                    'type' => 'hidden',
                    'value' => 'ativo'
                ]) ?>
                <?= $this->Form->control('criado_em', [
                    'type' => 'hidden',
                    'value' => date('Y-m-d H:i:s')
                ]) ?>

                <div class="form-actions">
                    <?= $this->Html->link('Cancelar', ['action' => 'login'], [
                        'class' => 'btn btn-secondary'
                    ]) ?>
                    <?= $this->Form->button(('Criar Minha Conta'), [
                        'class' => 'btn btn-primary submit-btn',
                        'type' => 'submit'
                    ]) ?>
                </div>
            <?= $this->Form->end() ?>

            <div class="login-redirect">
                <p>Já tem uma conta?
                    <?= $this->Html->link(('Fazer Login'), ['action' => 'login'], [
                        'class' => 'login-link'
                    ]) ?>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
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

.section-title i {
    color: #7c3aed;
    font-size: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.input-container {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 18px;
    z-index: 2;
}

.form-input {
    width: 100%;
    padding: 14px 16px 14px 50px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: white;
    color: #374151;
    font-family: inherit;
}

.select-input {
    appearance: none;
    cursor: pointer;
}

.select-arrow {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 14px;
    pointer-events: none;
}

.textarea-input {
    resize: vertical;
    min-height: 80px;
    padding: 14px 16px;
}

.form-input:focus {
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    outline: none;
    transform: translateY(-1px);
}

/* Password Strength */
.password-strength {
    margin-top: 8px;
}

.strength-bar {
    height: 6px;
    background: #e5e7eb;
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 6px;
}

.strength-fill {
    height: 100%;
    background: #ef4444;
    transition: all 0.3s ease;
    width: 0%;
}

.strength-fill.weak { background: #ef4444; width: 25%; }
.strength-fill.medium { background: #f59e0b; width: 50%; }
.strength-fill.strong { background: #10b981; width: 75%; }
.strength-fill.very-strong { background: #059669; width: 100%; }

.strength-text {
    font-size: 12px;
    color: #6b7280;
    font-weight: 500;
}

/* File Upload */
.file-upload-container {
    position: relative;
}

.file-upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 10px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    background: #f9fafb;
}

.file-upload-area:hover {
    border-color: #7c3aed;
    background: #faf5ff;
}

.file-upload-area.dragover {
    border-color: #7c3aed;
    background: #f3f4f6;
}

.upload-icon {
    font-size: 48px;
    color: #9ca3af;
    margin-bottom: 12px;
}

.upload-text {
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}

.upload-hint {
    font-size: 14px;
    color: #6b7280;
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-preview {
    margin-top: 15px;
    text-align: center;
}

.file-preview img {
    max-width: 150px;
    max-height: 150px;
    border-radius: 8px;
    border: 2px solid #e5e7eb;
}

/* Toggle Password */
.toggle-password {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    cursor: pointer;
    font-size: 18px;
    z-index: 2;
}

.toggle-password:hover {
    color: #374151;
}

/* Buttons */
.form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 28px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    min-width: 140px;
}

.btn-primary {
    background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
}

.btn-secondary {
    background: white;
    color: #374151;
    border: 2px solid #d1d5db;
}

.btn-secondary:hover {
    border-color: #9ca3af;
    transform: translateY(-2px);
}

/* Login Redirect */
.login-redirect {
    text-align: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
    color: #6b7280;
}

.login-link {
    color: #7c3aed;
    text-decoration: none;
    font-weight: 600;
}

.login-link:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 768px) {
    .register-container {
        padding: 10px;
    }

    .card-body {
        padding: 24px;
    }

    .card-header {
        padding: 30px 24px;
    }

    .header-icon {
        width: 60px;
        height: 60px;
        font-size: 24px;
    }

    .form-grid {
        gap: 20px;
    }

    .form-section {
        padding: 20px;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const strengthFill = document.getElementById('strength-fill');
    const strengthText = document.getElementById('strength-text');
    const togglePassword = document.getElementById('togglePassword');

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let text = '';
            let className = '';

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/\d/)) strength++;
            if (password.match(/[^a-zA-Z\d]/)) strength++;

            switch(strength) {
                case 0:
                    text = 'Muito Fraca';
                    className = '';
                    break;
                case 1:
                    text = 'Fraca';
                    className = 'weak';
                    break;
                case 2:
                    text = 'Moderada';
                    className = 'medium';
                    break;
                case 3:
                    text = 'Forte';
                    className = 'strong';
                    break;
                case 4:
                    text = 'Muito Forte';
                    className = 'very-strong';
                    break;
            }

            strengthFill.className = 'strength-fill ' + className;
            strengthText.textContent = Força da senha: ${text};
        });
    }

    // Toggle password visibility
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    // File upload preview
    const fileInput = document.getElementById('fotoPerfil');
    const fileUploadArea = document.getElementById('fileUploadArea');
    const filePreview = document.getElementById('filePreview');

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        filePreview.innerHTML = <img src="${e.target.result}" alt="Preview">;
                    };
                    reader.readAsDataURL(file);
                } else {
                    filePreview.innerHTML = '<p class="text-error">Por favor, selecione uma imagem.</p>';
                }
            }
        });

        // Drag and drop
        fileUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        fileUploadArea.addEventListener('dragleave', function() {
            this.classList.remove('dragover');
        });

        fileUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            fileInput.files = e.dataTransfer.files;
            fileInput.dispatchEvent(new Event('change'));
        });
    }
});
</script>