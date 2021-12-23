<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Validation;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\ErrorSummary;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\LoginValidatorForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class ValidationTest extends TestCase
{
    use TestTrait;

    private array $fieldConfig = [
        'errorClass()' => ['hasError'],
        'hintClass()' => ['info-class'],
        'invalidClass()' => ['is-invalid'],
        'validClass()' => ['is-valid'],
    ];

    public function testLoginAndPasswordValidatorInvalid(): void
    {
        $loginValidatorForm = new loginValidatorForm();
        $validator = $this->createValidatorMock();

        $loginValidatorForm->setAttribute('login', 'joe');
        $loginValidatorForm->setAttribute('password', '123456');
        $validator->validate($loginValidatorForm);

        $expected = <<<HTML
        <div>
        <label for="loginvalidatorform-login">Login</label>
        <input type="text" id="loginvalidatorform-login" class="is-invalid" name="LoginValidatorForm[login]" value="joe" required>
        </div>
        <div>
        <label for="loginvalidatorform-password">Password</label>
        <input type="text" id="loginvalidatorform-password" class="is-invalid" name="LoginValidatorForm[password]" value="123456" required>
        <div class="hasError">invalid login password</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->text($loginValidatorForm, 'login')->render() . PHP_EOL .
            Field::widget($this->fieldConfig)->text($loginValidatorForm, 'password')->render()
        );
    }

    public function testLoginAndPasswordValidatorValid(): void
    {
        $loginValidatorForm = new loginValidatorForm();
        $validator = $this->createValidatorMock();

        $loginValidatorForm->setAttribute('login', 'admin');
        $loginValidatorForm->setAttribute('password', 'admin');
        $validator->validate($loginValidatorForm);

        $expected = <<<HTML
        <div>
        <label for="loginvalidatorform-login">Login</label>
        <input type="text" id="loginvalidatorform-login" class="is-valid" name="LoginValidatorForm[login]" value="admin" required>
        </div>
        <div>
        <label for="loginvalidatorform-password">Password</label>
        <input type="text" id="loginvalidatorform-password" class="is-valid" name="LoginValidatorForm[password]" value="admin" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->text($loginValidatorForm, 'login')->render() . PHP_EOL .
            Field::widget($this->fieldConfig)->text($loginValidatorForm, 'password')->render()
        );
    }

    public function testLoginAndPasswordValidatorInvaliWithErrorSummary(): void
    {
        $loginValidatorForm = new loginValidatorForm();
        $validator = $this->createValidatorMock();

        $loginValidatorForm->setAttribute('login', 'joe');
        $loginValidatorForm->setAttribute('password', '123456');
        $validator->validate($loginValidatorForm);

        $expected = <<<HTML
        <div>
        <label for="loginvalidatorform-login">Login</label>
        <input type="text" id="loginvalidatorform-login" class="is-invalid" name="LoginValidatorForm[login]" value="joe" required>
        </div>
        <div>
        <label for="loginvalidatorform-password">Password</label>
        <input type="text" id="loginvalidatorform-password" class="is-invalid" name="LoginValidatorForm[password]" value="123456" required>
        </div>
        <div>
        <p>Please fix the following errors:</p>
        <ul>
        <li>invalid login password</li>
        </ul>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)
                ->text($loginValidatorForm, 'login')
                ->withoutError()
                ->render() . PHP_EOL .
            Field::widget($this->fieldConfig)
                ->text($loginValidatorForm, 'password')
                ->withoutError()
                ->render() . PHP_EOL .
            ErrorSummary::widget()->model($loginValidatorForm)->render(),
        );
    }

    public function testLoginAndPasswordValidatorValidWithErrorSummary(): void
    {
        $loginValidatorForm = new loginValidatorForm();
        $validator = $this->createValidatorMock();

        $loginValidatorForm->setAttribute('login', 'admin');
        $loginValidatorForm->setAttribute('password', 'admin');
        $validator->validate($loginValidatorForm);

        $expected = <<<HTML
        <div>
        <label for="loginvalidatorform-login">Login</label>
        <input type="text" id="loginvalidatorform-login" class="is-valid" name="LoginValidatorForm[login]" value="admin" required>
        </div>
        <div>
        <label for="loginvalidatorform-password">Password</label>
        <input type="text" id="loginvalidatorform-password" class="is-valid" name="LoginValidatorForm[password]" value="admin" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->text($loginValidatorForm, 'login')->render() . PHP_EOL .
            Field::widget($this->fieldConfig)->text($loginValidatorForm, 'password')->render() .
            ErrorSummary::widget()->model($loginValidatorForm)->render(),
        );
    }
}
