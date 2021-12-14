<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\TestSupport\Form;

use Yii\Extension\Simple\Model\FormModel;

final class LoginForm extends FormModel
{
    private ?string $login = '';
    private ?string $password = '';
}
