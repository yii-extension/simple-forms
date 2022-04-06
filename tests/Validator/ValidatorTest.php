<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Validator;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\ErrorSummary;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\Form\LoginValidator;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class ValidatorTest extends TestCase
{
    use TestTrait;

    private array $fieldConfig = [
        'errorClass()' => ['hasError'],
        'hintClass()' => ['info-class'],
        'invalidClass()' => ['is-invalid'],
        'validClass()' => ['is-valid'],
    ];

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLoginAndPasswordValidatorInvalid(): void
    {
        $loginValidatorForm = new LoginValidator();
        $loginValidatorForm->setValue('login', 'joe');
        $loginValidatorForm->setValue('password', '123456');
        $loginValidatorForm->validate();

        $config = array_merge(
            $this->fieldConfig,
            ['defaultValues()' => [['text' => ['errorAttributes' => ['class' => 'test-class']]]]],
        );

        $expected = <<<HTML
        <div>
        <label for="loginvalidator-login">Login</label>
        <input type="text" id="loginvalidator-login" class="is-invalid" name="LoginValidator[login]" value="joe" required>
        </div>
        <div>
        <label for="loginvalidator-password">Password</label>
        <input type="text" id="loginvalidator-password" class="is-invalid" name="LoginValidator[password]" value="123456" required>
        <div class="test-class hasError">invalid login password</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create($config)->text($loginValidatorForm, 'login')->render() . PHP_EOL .
            Field::create($config)->text($loginValidatorForm, 'password')->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLoginAndPasswordValidatorValid(): void
    {
        $loginValidatorForm = new LoginValidator();
        $loginValidatorForm->setValue('login', 'admin');
        $loginValidatorForm->setValue('password', 'admin');
        $loginValidatorForm->validate();

        $expected = <<<HTML
        <div>
        <label for="loginvalidator-login">Login</label>
        <input type="text" id="loginvalidator-login" name="LoginValidator[login]" value="admin" required>
        </div>
        <div>
        <label for="loginvalidator-password">Password</label>
        <input type="text" id="loginvalidator-password" name="LoginValidator[password]" value="admin" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create($this->fieldConfig)->text($loginValidatorForm, 'login')->render() . PHP_EOL .
            Field::create($this->fieldConfig)->text($loginValidatorForm, 'password')->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLoginAndPasswordValidatorInvalidWithErrorSummary(): void
    {
        $loginValidatorForm = new LoginValidator();
        $loginValidatorForm->setValue('login', 'joe');
        $loginValidatorForm->setValue('password', '123456');
        $loginValidatorForm->validate();

        $expected = <<<HTML
        <div>
        <label for="loginvalidator-login">Login</label>
        <input type="text" id="loginvalidator-login" class="is-invalid" name="LoginValidator[login]" value="joe" required>
        </div>
        <div>
        <label for="loginvalidator-password">Password</label>
        <input type="text" id="loginvalidator-password" class="is-invalid" name="LoginValidator[password]" value="123456" required>
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
            Field::create($this->fieldConfig)
                ->error(null)
                ->text($loginValidatorForm, 'login')
                ->render() . PHP_EOL .
            Field::create($this->fieldConfig)
                ->error(null)
                ->text($loginValidatorForm, 'password')
                ->render() . PHP_EOL .
            ErrorSummary::create()->model($loginValidatorForm)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLoginAndPasswordValidatorValidWithErrorSummary(): void
    {
        $loginValidatorForm = new LoginValidator();
        $loginValidatorForm->setValue('login', 'admin');
        $loginValidatorForm->setValue('password', 'admin');
        $loginValidatorForm->validate();

        $expected = <<<HTML
        <div>
        <label for="loginvalidator-login">Login</label>
        <input type="text" id="loginvalidator-login" name="LoginValidator[login]" value="admin" required>
        </div>
        <div>
        <label for="loginvalidator-password">Password</label>
        <input type="text" id="loginvalidator-password" name="LoginValidator[password]" value="admin" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create($this->fieldConfig)->text($loginValidatorForm, 'login')->render() . PHP_EOL .
            Field::create($this->fieldConfig)->text($loginValidatorForm, 'password')->render() .
            ErrorSummary::create()->model($loginValidatorForm)->render(),
        );
    }

    public function testUrlValidatorPatternSchemeCaseInsensitive(): void
    {
        $validatorRules = new ValidatorRules();
        $validatorRules->setValue('urlWithPattern', 'https://www.yiiframework.com/');
        $validatorRules->validate();

        $expected = <<<HTML
        <div>
        <label for="validatorrules-urlwithpattern">Url With Pattern</label>
        <input type="url" id="validatorrules-urlwithpattern" name="ValidatorRules[urlWithPattern]" value="https://www.yiiframework.com/" pattern="^([hH][tT][tT][pP]|[hH][tT][tT][pP][sS]):\/\/(([a-zA-Z0-9][a-zA-Z0-9_-]*)(\.[a-zA-Z0-9][a-zA-Z0-9_-]*)+)(?::\d{1,5})?([?\/#].*$|$)">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create($this->fieldConfig)->url($validatorRules, 'urlWithPattern')->render(),
        );
    }
}
