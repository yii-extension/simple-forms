<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\TestSupport\Form;

use Yii\Extension\Simple\Model\BaseModel;

final class TypeForm extends BaseModel
{
    private array $array = [];
    private bool $bool = false;
    private float $float = 0;
    private int $int = 0;
    private ?object $object = null;
    private string $string = '';
    private string $toCamelCase = '';
    private string $toDate = '';
    private ?string $toNull = null;

    public function getAttributeHints(): array
    {
        return [
            'string' => 'Write your text string.',
        ];
    }

    public function getAttributePlaceholders(): array
    {
        return [
            'string' => 'Typed your text string.',
        ];
    }
}
