<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Password;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;

final class PasswordTest extends TestCase
{
    private TypeForm $model;

    public function testForm(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" value form="form-id">',
            Password::widget()->config($this->model, 'string')->form('form-id')->render(),
        );
    }

    public function testImmutability(): void
    {
        $password = Password::widget();
        $this->assertNotSame($password, $password->form(''));
        $this->assertNotSame($password, $password->maxlength(0));
        $this->assertNotSame($password, $password->minlength(0));
        $this->assertNotSame($password, $password->pattern(''));
        $this->assertNotSame($password, $password->placeHolder(''));
        $this->assertNotSame($password, $password->readOnly());
    }

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" value maxlength="16">',
            Password::widget()->config($this->model, 'string')->maxlength(16)->render(),
        );
    }

    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" value minlength="8">',
            Password::widget()->config($this->model, 'string')->minlength(8)->render(),
        );
    }

    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <input type="password" id="typeform-string" name="TypeForm[string]" value title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
        HTML;
        $html = Password::widget()
            ->config($this->model, 'string', [
                'title' => 'Must contain at least one number and one uppercase and lowercase letter, and at least 8 ' .
                'or more characters.',
            ])
            ->pattern('(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}')
            ->render();
        $this->assertSame($expected, $html);
    }

    public function testPlaceholder(): void
    {
        $expected = <<<'HTML'
        HTML;
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" value placeholder="PlaceHolder Text">',
            Password::widget()->config($this->model, 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    public function testReadOnly(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" value readonly>',
            Password::widget()->config($this->model, 'string')->readOnly()->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" value>',
            $html = Password::widget()->config($this->model, 'string')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password widget must be a string.');
        Password::widget()->config($this->model, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
