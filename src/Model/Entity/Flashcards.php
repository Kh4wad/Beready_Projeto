<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class FlashcardTag extends Entity
{
    protected array $_accessible = [
        'nome' => true,
        'created' => true,
        'modified' => true,
        'flashcard_tags' => true,
    ];
}
