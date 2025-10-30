<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Flashcard $flashcard
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Flashcard'), ['action' => 'edit', $flashcard->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Flashcard'), ['action' => 'delete', $flashcard->id], ['confirm' => __('Are you sure you want to delete # {0}?', $flashcard->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Flashcards'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Flashcard'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="flashcards view content">
            <h3><?= h($flashcard->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Usuario') ?></th>
                    <td><?= $flashcard->hasValue('usuario') ? $this->Html->link($flashcard->usuario->nome, ['controller' => 'Usuarios', 'action' => 'view', $flashcard->usuario->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Prompt') ?></th>
                    <td><?= $flashcard->hasValue('prompt') ? $this->Html->link($flashcard->prompt->id, ['controller' => 'Prompts', 'action' => 'view', $flashcard->prompt->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Imagem Frente') ?></th>
                    <td><?= $flashcard->hasValue('imagem_frente') ? $this->Html->link($flashcard->imagem_frente->id, ['controller' => 'ImagensGeradas', 'action' => 'view', $flashcard->imagem_frente->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Imagem Verso') ?></th>
                    <td><?= $flashcard->hasValue('imagem_verso') ? $this->Html->link($flashcard->imagem_verso->id, ['controller' => 'ImagensGeradas', 'action' => 'view', $flashcard->imagem_verso->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Audio Frente Url') ?></th>
                    <td><?= h($flashcard->audio_frente_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Audio Verso Url') ?></th>
                    <td><?= h($flashcard->audio_verso_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nivel Dificuldade') ?></th>
                    <td><?= h($flashcard->nivel_dificuldade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo Criacao') ?></th>
                    <td><?= h($flashcard->tipo_criacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($flashcard->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Vezes Revisado') ?></th>
                    <td><?= $flashcard->vezes_revisado === null ? '' : $this->Number->format($flashcard->vezes_revisado) ?></td>
                </tr>
                <tr>
                    <th><?= __('Vezes Acertado') ?></th>
                    <td><?= $flashcard->vezes_acertado === null ? '' : $this->Number->format($flashcard->vezes_acertado) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ultima Revisao') ?></th>
                    <td><?= h($flashcard->ultima_revisao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Proxima Revisao') ?></th>
                    <td><?= h($flashcard->proxima_revisao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Criado Em') ?></th>
                    <td><?= h($flashcard->criado_em) ?></td>
                </tr>
                <tr>
                    <th><?= __('Arquivado') ?></th>
                    <td><?= $flashcard->arquivado ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Texto Frente') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($flashcard->texto_frente)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Texto Verso') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($flashcard->texto_verso)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Flashcard Tags') ?></h4>
                <?php if (!empty($flashcard->flashcard_tags)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Flashcard Id') ?></th>
                            <th><?= __('Tag Id') ?></th>
                            <th><?= __('Criado Em') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($flashcard->flashcard_tags as $flashcardTag) : ?>
                        <tr>
                            <td><?= h($flashcardTag->id) ?></td>
                            <td><?= h($flashcardTag->flashcard_id) ?></td>
                            <td><?= h($flashcardTag->tag_id) ?></td>
                            <td><?= h($flashcardTag->criado_em) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'FlashcardTags', 'action' => 'view', $flashcardTag->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'FlashcardTags', 'action' => 'edit', $flashcardTag->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'FlashcardTags', 'action' => 'delete', $flashcardTag->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $flashcardTag->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>