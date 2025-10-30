<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Flashcard Entity
 *
 * @property int $id
 * @property int $usuario_id
 * @property int|null $prompt_id
 * @property string|null $texto_frente
 * @property string|null $texto_verso
 * @property int|null $imagem_frente_id
 * @property int|null $imagem_verso_id
 * @property string|null $audio_frente_url
 * @property string|null $audio_verso_url
 * @property string|null $nivel_dificuldade
 * @property string|null $tipo_criacao
 * @property int|null $vezes_revisado
 * @property int|null $vezes_acertado
 * @property \Cake\I18n\DateTime|null $ultima_revisao
 * @property \Cake\I18n\DateTime|null $proxima_revisao
 * @property bool|null $arquivado
 * @property \Cake\I18n\DateTime|null $criado_em
 *
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\Prompt $prompt
 * @property \App\Model\Entity\ImagemFrente $imagem_frente
 * @property \App\Model\Entity\ImagemVerso $imagem_verso
 * @property \App\Model\Entity\FlashcardTag[] $flashcard_tags
 */
class Flashcard extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'usuario_id' => true,
        'prompt_id' => true,
        'texto_frente' => true,
        'texto_verso' => true,
        'imagem_frente_id' => true,
        'imagem_verso_id' => true,
        'audio_frente_url' => true,
        'audio_verso_url' => true,
        'nivel_dificuldade' => true,
        'tipo_criacao' => true,
        'vezes_revisado' => true,
        'vezes_acertado' => true,
        'ultima_revisao' => true,
        'proxima_revisao' => true,
        'arquivado' => true,
        'criado_em' => true,
        'usuario' => true,
        'prompt' => true,
        'imagem_frente' => true,
        'imagem_verso' => true,
        'flashcard_tags' => true,
    ];
}
