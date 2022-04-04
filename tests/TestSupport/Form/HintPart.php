<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\TestSupport\Form;

use Yii\Extension\FormModel\FormModel;

final class HintPart extends FormModel
{
    private ?string $hint = '';

    public function getHints(): array
    {
        return [
            'hint' => 'Please enter your hint.',
        ];
    }
}
