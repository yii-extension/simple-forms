<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\TestSupport\Form;

use Yii\Extension\Simple\Model\FormModel;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Required;

final class ValidatorForm extends FormModel
{
    private string $name = '';

    public function getAttributeHints(): array
    {
        return [
            'name' => 'Write your first name.',
        ];
    }

    public function getRules(): array
    {
        return [
            'name' => [Required::rule(), HasLength::rule()->min(4)->tooShortMessage('Is too short.')],
        ];
    }
}
