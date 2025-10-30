<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Flashcard $flashcard
 * @var \Cake\Collection\CollectionInterface|string[] $usuarios
 * @var \Cake\Collection\CollectionInterface|string[] $prompts
 * @var \Cake\Collection\CollectionInterface|string[] $imagemFrentes
 * @var \Cake\Collection\CollectionInterface|string[] $imagemVersos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Flashcards'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="flashcards form content">
            <?= $this->Form->create($flashcard) ?>
            <fieldset>
                <legend><?= __('Add Flashcard') ?></legend>
                <?php
                    echo $this->Form->control('usuario_id', ['options' => $usuarios]);
                    echo $this->Form->control('prompt_id', ['options' => $prompts, 'empty' => true]);
                    echo $this->Form->control('texto_frente');
                    echo $this->Form->control('texto_verso');
                    echo $this->Form->control('imagem_frente_id', ['options' => $imagemFrentes, 'empty' => true]);
                    echo $this->Form->control('imagem_verso_id', ['options' => $imagemVersos, 'empty' => true]);
                    echo $this->Form->control('audio_frente_url');
                    echo $this->Form->control('audio_verso_url');
                    echo $this->Form->control('nivel_dificuldade');
                    echo $this->Form->control('tipo_criacao');
                    echo $this->Form->control('vezes_revisado');
                    echo $this->Form->control('vezes_acertado');
                    echo $this->Form->control('ultima_revisao');
                    echo $this->Form->control('proxima_revisao');
                    echo $this->Form->control('arquivado');
                    echo $this->Form->control('criado_em');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
