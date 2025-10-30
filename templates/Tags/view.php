<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tag'), ['action' => 'edit', $tag->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tag'), ['action' => 'delete', $tag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tag->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tag'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tags view content">
            <h3><?= h($tag->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($tag->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cor') ?></th>
                    <td><?= h($tag->cor) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tag->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Criado Por') ?></th>
                    <td><?= $tag->criado_por === null ? '' : $this->Number->format($tag->criado_por) ?></td>
                </tr>
                <tr>
                    <th><?= __('Criado Em') ?></th>
                    <td><?= h($tag->criado_em) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tag Sistema') ?></th>
                    <td><?= $tag->tag_sistema ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Descricao') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($tag->descricao)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Flashcard Tags') ?></h4>
                <?php if (!empty($tag->flashcard_tags)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Flashcard Id') ?></th>
                            <th><?= __('Tag Id') ?></th>
                            <th><?= __('Criado Em') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($tag->flashcard_tags as $flashcardTag) : ?>
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