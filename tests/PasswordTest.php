<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Password;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\LoginForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\ValidatorForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class PasswordTest extends TestCase
{
    use TestTrait;

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" autofocus>',
            Password::widget()->autofocus()->for(new LoginForm(), 'password')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDisabled(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="password" id="loginform-password" name="LoginForm[password]" disabled>',
            Password::widget()->disabled()->for(new LoginForm(), 'password')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorMatchRegularExpression(): void
    {
        $this->assertSame(
            '<input type="password" id="validatorform-matchregular" name="ValidatorForm[matchregular]" pattern="\w+">',
            Password::widget()->for(new ValidatorForm(), 'matchregular')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="password" id="validatorform-maxlength" name="ValidatorForm[maxlength]" maxlength="50">',
            Password::widget()->for(new ValidatorForm(), 'maxlength')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="password" id="validatorform-minlength" name="ValidatorForm[minlength]" minlength="15">',
            Password::widget()->for(new ValidatorForm(), 'minlength')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="password" id="validatorform-required" name="ValidatorForm[required]" required>',
            Password::widget()->for(new ValidatorForm(), 'required')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="password" id="id-test" name="LoginForm[password]">',
            Password::widget()->for(new LoginForm(), 'password')->id('id-test')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testImmutability(): void
    {
        $password = Password::widget();
        $this->assertNotSame($password, $password->maxlength(0));
        $this->assertNotSame($password, $password->minlength(4));
        $this->assertNotSame($password, $password->pattern(''));
        $this->assertNotSame($password, $password->placeholder(''));
        $this->assertNotSame($password, $password->readonly());
        $this->assertNotSame($password, $password->size(0));
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" maxlength="16">',
            Password::widget()->for(new LoginForm(), 'password')->maxlength(16)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" minlength="8">',
            Password::widget()->for(new LoginForm(), 'password')->minlength(8)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="name-test">',
            Password::widget()->for(new LoginForm(), 'password')->name('name-test')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testPattern(): void
    {
        $expected = <<<HTML
        <input type="password" id="loginform-password" name="LoginForm[password]" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
        HTML;
        $this->assertSame(
            $expected,
            Password::widget()
                ->for(new LoginForm(), 'password')
                ->pattern('(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}')
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" placeholder="PlaceHolder Text">',
            Password::widget()->for(new LoginForm(), 'password')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testReadOnly(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" readonly>',
            Password::widget()->for(new LoginForm(), 'password')->readonly()->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" required>',
            Password::widget()->for(new LoginForm(), 'password')->required()->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]">',
            Password::widget()->for(new LoginForm(), 'password')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testSize(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" size="3">',
            Password::widget()->for(new LoginForm(), 'password')->size(3)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testTabIndex(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="password" id="loginform-password" name="LoginForm[password]" tabindex="1">',
            Password::widget()->for(new LoginForm(), 'password')->tabIndex(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValue(): void
    {
        // Value `null`.
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]">',
            Password::widget()->for(new LoginForm(), 'password')->value(null)->render(),
        );

        // Value string `1234??`.
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" value="1234??">',
            Password::widget()->for(new LoginForm(), 'password')->value('1234??')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password widget must be a string or null value.');
        Password::widget()->for(new TypeForm(), 'array')->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueWithForm(): void
    {
        $formModel = new LoginForm();

        // Value `null`.
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]">',
            Password::widget()->for($formModel, 'password')->render(),
        );

        // Value string `1234??`.
        $formModel->setAttribute('password', '1234??');
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" value="1234??">',
            Password::widget()->for($formModel, 'password')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="password" name="LoginForm[password]">',
            Password::widget()->for(new LoginForm(), 'password')->id(null)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password">',
            Password::widget()->for(new LoginForm(), 'password')->name(null)->render(),
        );
    }
}
