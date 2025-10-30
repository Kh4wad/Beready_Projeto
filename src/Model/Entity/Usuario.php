<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Usuario Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $senha_hash
 * @property string|null $telefone
 * @property string|null $foto_perfil
 * @property string|null $nivel_ingles
 * @property string|null $idioma_preferido
 * @property string|null $objetivos_aprendizado
 * @property string|null $status
 * @property \Cake\I18n\DateTime|null $criado_em
 * @property \Cake\I18n\DateTime|null $atualizado_em
 * @property \Cake\I18n\DateTime|null $ultimo_login
 *
 * @property \App\Model\Entity\ProgressoUsuario $progresso_usuario
 * @property \App\Model\Entity\Flashcard[] $flashcards
 * @property \App\Model\Entity\PreferenciasUsuario[] $preferencias_usuario
 * @property \App\Model\Entity\Prompt[] $prompts
 * @property \App\Model\Entity\Quize[] $quizes
 * @property \App\Model\Entity\TentativasQuiz[] $tentativas_quiz
 * @property \App\Model\Entity\Vocabulario[] $vocabulario
 */
class Usuario extends Entity
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
        'nome' => true,
        'email' => true,
        'senha_hash' => true,
        'telefone' => true,
        'foto_perfil' => true,
        'nivel_ingles' => true,
        'idioma_preferido' => true,
        'objetivos_aprendizado' => true,
        'status' => true,
        'criado_em' => true,
        'atualizado_em' => true,
        'ultimo_login' => true,
        'progresso_usuario' => true,
        'flashcards' => true,
        'preferencias_usuario' => true,
        'prompts' => true,
        'quizes' => true,
        'tentativas_quiz' => true,
        'vocabulario' => true,
    ];
}
