<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Flashcard $flashcard
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Ações') ?></h4>
            <?= $this->Html->link(__('Editar Flashcard'), ['action' => 'edit', $flashcard->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Deletar Flashcard'), ['action' => 'delete', $flashcard->id], ['confirm' => __('Tem certeza que deseja deletar # {0}?', $flashcard->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Listar Flashcards'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Novo Flashcard'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="flashcards view content">
            <h3><?= h($flashcard->question) ?></h3>
            <table>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($flashcard->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Usuário') ?></th>
                    <td><?= $flashcard->hasValue('user') ? $this->Html->link($flashcard->user->email, ['controller' => 'Users', 'action' => 'view', $flashcard->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Pergunta') ?></th>
                    <td><?= h($flashcard->question) ?></td>
                </tr>
                <tr>
                    <th><?= __('Resposta') ?></th>
                    <td><?= h($flashcard->answer) ?></td>
                </tr>
                <tr>
                    <th><?= __('Criado em') ?></th>
                    <td><?= h($flashcard->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modificado em') ?></th>
                    <td><?= h($flashcard->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
