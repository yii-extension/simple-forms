<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\TestSupport\Form;

use Yii\Extension\Model\FormModel;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Regex;
use Yiisoft\Validator\Rule\Required;

final class CustomError extends FormModel
{
    #[Email]
    private string $email = '';

    #[Required]
    #[HasLength(min: 4, tooShortMessage: 'Is too short.')]
    private string $login = '';

    #[Required]
    #[Regex(
        pattern: '/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/',
        message: 'Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more ' .
        'characters.'
    )]
    private string $password = '';

    public function customError(): string
    {
        return 'This is custom error message.';
    }

    public function customErrorWithIcon(): string
    {
        return '(&#10006;) This is custom error message.';
    }

    public function getHints(): array
    {
        return [
            'name' => 'Write your login.',
        ];
    }
}
