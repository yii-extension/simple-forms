<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\TestSupport\Form;

use Yii\Extension\Model\FormModel;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\Rule\Required;

final class LoginValidator extends FormModel
{
    private ?string $login = '';
    private ?string $password = '';
    private array $users = ['admin' => 'admin', 'user' => 'user'];

    public function getRules(): array
    {
        return [
            'login' => [new Required()],
            'password' => $this->passwordRules(),
        ];
    }

    private function passwordRules(): array
    {
        $formErrors = $this->error();
        $login = $this->login;
        $password = $this->password;
        $users = $this->users;

        return [
            new Required(),
            static function () use ($formErrors, $login, $password, $users): Result {
                $result = new Result();

                if (!in_array($login, $users, true) || $password !== $users[$login]) {
                    $formErrors->add('login', '');
                    $result->addError('invalid login password');
                }

                return $result;
            },
        ];
    }
}
