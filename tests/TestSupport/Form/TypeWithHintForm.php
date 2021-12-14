<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\TestSupport\Form;

use Yii\Extension\Simple\Model\FormModel;

final class TypeWithHintForm extends FormModel
{
    private ?string $login = '';
    private ?string $password = '';

    public function getAttributeHints(): array
    {
        return [
            'login' => 'Please enter your login.',
            'password' => 'Please enter your password.',
        ];
    }
}
