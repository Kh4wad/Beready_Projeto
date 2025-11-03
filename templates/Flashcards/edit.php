<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Flashcard $flashcard
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Ações') ?></h4>
            <?= $this->Form->postLink(
                __('Deletar'),
                ['action' => 'delete', $flashcard->id],
                ['confirm' => __('Tem certeza que deseja deletar # {0}?', $flashcard->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('Listar Flashcards'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="flashcards form content">
            <?= $this->Form->create($flashcard) ?>
            <fieldset>
                <legend><?= __('Editar Flashcard') ?></legend>
                <?php
                    echo $this->Form->control('question', ['label' => 'Pergunta']);
                    echo $this->Form->control('answer', ['label' => 'Resposta']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Salvar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
