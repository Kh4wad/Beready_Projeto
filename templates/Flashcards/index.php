<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Flashcard> $flashcards
 */
?>
<div class="flashcards index content">
    <?= $this->Html->link(__('New Flashcard'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Flashcards') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('usuario_id') ?></th>
                    <th><?= $this->Paginator->sort('prompt_id') ?></th>
                    <th><?= $this->Paginator->sort('imagem_frente_id') ?></th>
                    <th><?= $this->Paginator->sort('imagem_verso_id') ?></th>
                    <th><?= $this->Paginator->sort('audio_frente_url') ?></th>
                    <th><?= $this->Paginator->sort('audio_verso_url') ?></th>
                    <th><?= $this->Paginator->sort('nivel_dificuldade') ?></th>
                    <th><?= $this->Paginator->sort('tipo_criacao') ?></th>
                    <th><?= $this->Paginator->sort('vezes_revisado') ?></th>
                    <th><?= $this->Paginator->sort('vezes_acertado') ?></th>
                    <th><?= $this->Paginator->sort('ultima_revisao') ?></th>
                    <th><?= $this->Paginator->sort('proxima_revisao') ?></th>
                    <th><?= $this->Paginator->sort('arquivado') ?></th>
                    <th><?= $this->Paginator->sort('criado_em') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($flashcards as $flashcard): ?>
                <tr>
                    <td><?= $this->Number->format($flashcard->id) ?></td>
                    <td><?= $flashcard->hasValue('usuario') ? $this->Html->link($flashcard->usuario->nome, ['controller' => 'Usuarios', 'action' => 'view', $flashcard->usuario->id]) : '' ?></td>
                    <td><?= $flashcard->hasValue('prompt') ? $this->Html->link($flashcard->prompt->id, ['controller' => 'Prompts', 'action' => 'view', $flashcard->prompt->id]) : '' ?></td>
                    <td><?= $flashcard->hasValue('imagem_frente') ? $this->Html->link($flashcard->imagem_frente->id, ['controller' => 'ImagensGeradas', 'action' => 'view', $flashcard->imagem_frente->id]) : '' ?></td>
                    <td><?= $flashcard->hasValue('imagem_verso') ? $this->Html->link($flashcard->imagem_verso->id, ['controller' => 'ImagensGeradas', 'action' => 'view', $flashcard->imagem_verso->id]) : '' ?></td>
                    <td><?= h($flashcard->audio_frente_url) ?></td>
                    <td><?= h($flashcard->audio_verso_url) ?></td>
                    <td><?= h($flashcard->nivel_dificuldade) ?></td>
                    <td><?= h($flashcard->tipo_criacao) ?></td>
                    <td><?= $flashcard->vezes_revisado === null ? '' : $this->Number->format($flashcard->vezes_revisado) ?></td>
                    <td><?= $flashcard->vezes_acertado === null ? '' : $this->Number->format($flashcard->vezes_acertado) ?></td>
                    <td><?= h($flashcard->ultima_revisao) ?></td>
                    <td><?= h($flashcard->proxima_revisao) ?></td>
                    <td><?= h($flashcard->arquivado) ?></td>
                    <td><?= h($flashcard->criado_em) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $flashcard->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $flashcard->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $flashcard->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $flashcard->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>