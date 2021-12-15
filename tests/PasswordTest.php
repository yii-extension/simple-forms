<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Password;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\LoginForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class PasswordTest extends TestCase
{
    use TestTrait;

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

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" maxlength="16">',
            Password::widget()->for(new LoginForm(), 'password')->maxlength(16)->render(),
        );
    }

    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" minlength="8">',
            Password::widget()->for(new LoginForm(), 'password')->minlength(8)->render(),
        );
    }

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

    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" placeholder="PlaceHolder Text">',
            Password::widget()->for(new LoginForm(), 'password')->placeholder('PlaceHolder Text')->render(),
        );
    }

    public function testReadOnly(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" readonly>',
            Password::widget()->for(new LoginForm(), 'password')->readonly()->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]">',
            Password::widget()->for(new LoginForm(), 'password')->render(),
        );
    }

    public function testSize(): void
    {
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" size="3">',
            Password::widget()->for(new LoginForm(), 'password')->size(3)->render(),
        );
    }

    public function testValue(): void
    {
        $formModel = new LoginForm();

        // Value `null`.
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]">',
            Password::widget()->for($formModel, 'password')->render(),
        );

        // value string '1234??'.
        $formModel->setAttribute('password', '1234??');
        $this->assertSame(
            '<input type="password" id="loginform-password" name="LoginForm[password]" value="1234??">',
            Password::widget()->for($formModel, 'password')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password widget must be a string or null value.');
        Password::widget()->for(new TypeForm(), 'array')->render();
    }
}
