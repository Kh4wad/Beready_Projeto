<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form content">
    <?= $this->Flash->render() ?>
    <h3><?= __('Redefinir Senha') ?></h3>
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Insira sua nova senha') ?></legend>
        <?= $this->Form->control('password', ['required' => true]) ?>
    </fieldset>
    <?= $this->Form->button(__('Redefinir Senha')); ?>
    <?= $this->Form->end() ?>
</div>
