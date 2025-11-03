<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Usuario $usuario
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $usuario->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $usuario->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(('List Usuarios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="usuarios form content">
            <?= $this->Form->create($usuario) ?>
            <fieldset>
                <legend><?= __('Edit Usuario') ?></legend>
                <?php
                    echo $this->Form->control('nome');
                    echo $this->Form->control('email');
                    echo $this->Form->control('senha_hash');
                    echo $this->Form->control('telefone');
                    echo $this->Form->control('foto_perfil');
                    echo $this->Form->control('nivel_ingles');
                    echo $this->Form->control('idioma_preferido');
                    echo $this->Form->control('objetivos_aprendizado');
                    echo $this->Form->control('status');
                    echo $this->Form->control('criado_em');
                    echo $this->Form->control('atualizado_em');
                    echo $this->Form->control('ultimo_login');
                ?>
            </fieldset>
            <?= $this->Form->button(('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>