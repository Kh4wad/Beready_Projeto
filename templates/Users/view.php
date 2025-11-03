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
            <?= $this->Html->link(('Edit Usuario'), ['action' => 'edit', $usuario->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(('Delete Usuario'), ['action' => 'delete', $usuario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usuario->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(('List Usuarios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(('New Usuario'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="usuarios view content">
            <h3><?= h($usuario->nome) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($usuario->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($usuario->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Senha Hash') ?></th>
                    <td><?= h($usuario->senha_hash) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= h($usuario->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Foto Perfil') ?></th>
                    <td><?= h($usuario->foto_perfil) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nivel Ingles') ?></th>
                    <td><?= h($usuario->nivel_ingles) ?></td>
                </tr>
                <tr>
                    <th><?= __('Idioma Preferido') ?></th>
                    <td><?= h($usuario->idioma_preferido) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($usuario->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Progresso Usuario') ?></th>
                    <td><?= $usuario->hasValue('progresso_usuario') ? $this->Html->link($usuario->progresso_usuario->id, ['controller' => 'ProgressoUsuario', 'action' => 'view', $usuario->progresso_usuario->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($usuario->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Criado Em') ?></th>
                    <td><?= h($usuario->criado_em) ?></td>
                </tr>
                <tr>
                    <th><?= __('Atualizado Em') ?></th>
                    <td><?= h($usuario->atualizado_em) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ultimo Login') ?></th>
                    <td><?= h($usuario->ultimo_login) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Objetivos Aprendizado') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($usuario->objetivos_aprendizado)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Flashcards') ?></h4>
                <?php if (!empty($usuario->flashcards)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Usuario Id') ?></th>
                            <th><?= __('Prompt Id') ?></th>
                            <th><?= __('Texto Frente') ?></th>
                            <th><?= __('Texto Verso') ?></th>
                            <th><?= __('Imagem Frente Id') ?></th>
                            <th><?= __('Imagem Verso Id') ?></th>
                            <th><?= __('Audio Frente Url') ?></th>
                            <th><?= __('Audio Verso Url') ?></th>
                            <th><?= __('Nivel Dificuldade') ?></th>
                            <th><?= __('Tipo Criacao') ?></th>
                            <th><?= __('Vezes Revisado') ?></th>
                            <th><?= __('Vezes Acertado') ?></th>
                            <th><?= __('Ultima Revisao') ?></th>
                            <th><?= __('Proxima Revisao') ?></th>
                            <th><?= __('Arquivado') ?></th>
                            <th><?= __('Criado Em') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($usuario->flashcards as $flashcard) : ?>
                        <tr>
                            <td><?= h($flashcard->id) ?></td>
                            <td><?= h($flashcard->usuario_id) ?></td>
                            <td><?= h($flashcard->prompt_id) ?></td>
                            <td><?= h($flashcard->texto_frente) ?></td>
                            <td><?= h($flashcard->texto_verso) ?></td>
                            <td><?= h($flashcard->imagem_frente_id) ?></td>
                            <td><?= h($flashcard->imagem_verso_id) ?></td>
                            <td><?= h($flashcard->audio_frente_url) ?></td>
                            <td><?= h($flashcard->audio_verso_url) ?></td>
                            <td><?= h($flashcard->nivel_dificuldade) ?></td>
                            <td><?= h($flashcard->tipo_criacao) ?></td>
                            <td><?= h($flashcard->vezes_revisado) ?></td>
                            <td><?= h($flashcard->vezes_acertado) ?></td>
                            <td><?= h($flashcard->ultima_revisao) ?></td>
                            <td><?= h($flashcard->proxima_revisao) ?></td>
                            <td><?= h($flashcard->arquivado) ?></td>
                            <td><?= h($flashcard->criado_em) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(('View'), ['controller' => 'Flashcards', 'action' => 'view', $flashcard->id]) ?>
                                <?= $this->Html->link(('Edit'), ['controller' => 'Flashcards', 'action' => 'edit', $flashcard->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Flashcards', 'action' => 'delete', $flashcard->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $flashcard->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Preferencias Usuario') ?></h4>
                <?php if (!empty($usuario->preferencias_usuario)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Usuario Id') ?></th>
                            <th><?= __('Tema') ?></th>
                            <th><?= __('Modo Daltonico') ?></th>
                            <th><?= __('Notificacoes Ativas') ?></th>
                            <th><?= __('Som Ativo') ?></th>
                            <th><?= __('Traducao Automatica') ?></th>
                            <th><?= __('Preferencia Dificuldade') ?></th>
                            <th><?= __('Meta Diaria Minutos') ?></th>
                            <th><?= __('Criado Em') ?></th>
                            <th><?= __('Atualizado Em') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($usuario->preferencias_usuario as $preferenciasUsuario) : ?>
                        <tr>
                            <td><?= h($preferenciasUsuario->id) ?></td>
                            <td><?= h($preferenciasUsuario->usuario_id) ?></td>
                            <td><?= h($preferenciasUsuario->tema) ?></td>
                            <td><?= h($preferenciasUsuario->modo_daltonico) ?></td>
                            <td><?= h($preferenciasUsuario->notificacoes_ativas) ?></td>
                            <td><?= h($preferenciasUsuario->som_ativo) ?></td>
                            <td><?= h($preferenciasUsuario->traducao_automatica) ?></td>
                            <td><?= h($preferenciasUsuario->preferencia_dificuldade) ?></td>
                            <td><?= h($preferenciasUsuario->meta_diaria_minutos) ?></td>
                            <td><?= h($preferenciasUsuario->criado_em) ?></td>
                            <td><?= h($preferenciasUsuario->atualizado_em) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(('View'), ['controller' => 'PreferenciasUsuario', 'action' => 'view', $preferenciasUsuario->id]) ?>
                                <?= $this->Html->link(('Edit'), ['controller' => 'PreferenciasUsuario', 'action' => 'edit', $preferenciasUsuario->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'PreferenciasUsuario', 'action' => 'delete', $preferenciasUsuario->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $preferenciasUsuario->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Prompts') ?></h4>
                <?php if (!empty($usuario->prompts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Usuario Id') ?></th>
                            <th><?= __('Texto Original') ?></th>
                            <th><?= __('Idioma Original') ?></th>
                            <th><?= __('Contexto') ?></th>
                            <th><?= __('Midia Origem Id') ?></th>
                            <th><?= __('Sessao Id') ?></th>
                            <th><?= __('Criado Em') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($usuario->prompts as $prompt) : ?>
                        <tr>
                            <td><?= h($prompt->id) ?></td>
                            <td><?= h($prompt->usuario_id) ?></td>
                            <td><?= h($prompt->texto_original) ?></td>
                            <td><?= h($prompt->idioma_original) ?></td>
                            <td><?= h($prompt->contexto) ?></td>
                            <td><?= h($prompt->midia_origem_id) ?></td>
                            <td><?= h($prompt->sessao_id) ?></td>
                            <td><?= h($prompt->criado_em) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(('View'), ['controller' => 'Prompts', 'action' => 'view', $prompt->id]) ?>
                                <?= $this->Html->link(('Edit'), ['controller' => 'Prompts', 'action' => 'edit', $prompt->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Prompts', 'action' => 'delete', $prompt->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $prompt->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Quizes') ?></h4>
                <?php if (!empty($usuario->quizes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Usuario Id') ?></th>
                            <th><?= __('Titulo') ?></th>
                            <th><?= __('Descricao') ?></th>
                            <th><?= __('Tipo Criacao') ?></th>
                            <th><?= __('Nivel Dificuldade') ?></th>
                            <th><?= __('Total Questoes') ?></th>
                            <th><?= __('Tempo Limite') ?></th>
                            <th><?= __('Publico') ?></th>
                            <th><?= __('Criado Em') ?></th>
                            <th><?= __('Atualizado Em') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($usuario->quizes as $quize) : ?>
                        <tr>
                            <td><?= h($quize->id) ?></td>
                            <td><?= h($quize->usuario_id) ?></td>
                            <td><?= h($quize->titulo) ?></td>
                            <td><?= h($quize->descricao) ?></td>
                            <td><?= h($quize->tipo_criacao) ?></td>
                            <td><?= h($quize->nivel_dificuldade) ?></td>
                            <td><?= h($quize->total_questoes) ?></td>
                            <td><?= h($quize->tempo_limite) ?></td>
                            <td><?= h($quize->publico) ?></td>
                            <td><?= h($quize->criado_em) ?></td>
                            <td><?= h($quize->atualizado_em) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(('View'), ['controller' => 'Quizes', 'action' => 'view', $quize->id]) ?>
                                <?= $this->Html->link(('Edit'), ['controller' => 'Quizes', 'action' => 'edit', $quize->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Quizes', 'action' => 'delete', $quize->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $quize->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Tentativas Quiz') ?></h4>
                <?php if (!empty($usuario->tentativas_quiz)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Quiz Id') ?></th>
                            <th><?= __('Usuario Id') ?></th>
                            <th><?= __('Pontuacao') ?></th>
                            <th><?= __('Pontuacao Maxima') ?></th>
                            <th><?= __('Porcentagem') ?></th>
                            <th><?= __('Tempo Gasto') ?></th>
                            <th><?= __('Respostas') ?></th>
                            <th><?= __('Concluido Em') ?></th>
                            <th><?= __('Criado Em') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($usuario->tentativas_quiz as $tentativasQuiz) : ?>
                        <tr>
                            <td><?= h($tentativasQuiz->id) ?></td>
                            <td><?= h($tentativasQuiz->quiz_id) ?></td>
                            <td><?= h($tentativasQuiz->usuario_id) ?></td>
                            <td><?= h($tentativasQuiz->pontuacao) ?></td>
                            <td><?= h($tentativasQuiz->pontuacao_maxima) ?></td>
                            <td><?= h($tentativasQuiz->porcentagem) ?></td>
                            <td><?= h($tentativasQuiz->tempo_gasto) ?></td>
                            <td><?= h($tentativasQuiz->respostas) ?></td>
                            <td><?= h($tentativasQuiz->concluido_em) ?></td>
                            <td><?= h($tentativasQuiz->criado_em) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(('View'), ['controller' => 'TentativasQuiz', 'action' => 'view', $tentativasQuiz->id]) ?>
                                <?= $this->Html->link(('Edit'), ['controller' => 'TentativasQuiz', 'action' => 'edit', $tentativasQuiz->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'TentativasQuiz', 'action' => 'delete', $tentativasQuiz->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $tentativasQuiz->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Vocabulario') ?></h4>
                <?php if (!empty($usuario->vocabulario)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Usuario Id') ?></th>
                            <th><?= __('Palavra Frase') ?></th>
                            <th><?= __('Criado Em') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($usuario->vocabulario as $vocabulario) : ?>
                        <tr>
                            <td><?= h($vocabulario->id) ?></td>
                            <td><?= h($vocabulario->usuario_id) ?></td>
                            <td><?= h($vocabulario->palavra_frase) ?></td>
                            <td><?= h($vocabulario->criado_em) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(('View'), ['controller' => 'Vocabulario', 'action' => 'view', $vocabulario->id]) ?>
                                <?= $this->Html->link(('Edit'), ['controller' => 'Vocabulario', 'action' => 'edit', $vocabulario->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Vocabulario', 'action' => 'delete', $vocabulario->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $vocabulario->id),
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