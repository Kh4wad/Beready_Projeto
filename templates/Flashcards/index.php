<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Flashcard> $flashcards
 */
?>
<div class="flashcards index content">
    <?= $this->Html->link(__('Novo Flashcard'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Flashcards') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('question', 'Pergunta') ?></th>
                    <th><?= $this->Paginator->sort('answer', 'Resposta') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Criado em') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($flashcards as $flashcard): ?>
                <tr>
                    <td><?= $this->Number->format($flashcard->id) ?></td>
                    <td><?= h($flashcard->question) ?></td>
                    <td><?= h($flashcard->answer) ?></td>
                    <td><?= h($flashcard->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Visualizar'), ['action' => 'view', $flashcard->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $flashcard->id]) ?>
                        <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $flashcard->id], ['confirm' => __('Tem certeza que deseja deletar # {0}?', $flashcard->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('primeira')) ?>
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('próxima') . ' >') ?>
            <?= $this->Paginator->last(__('última') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de {{count}} total')) ?></p>
    </div>
</div>
