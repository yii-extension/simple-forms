<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\LoginForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\ValidatorForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yii\Extension\Simple\Forms\Text;

final class TextTest extends TestCase
{
    use TestTrait;

    public function testDirname(): void
    {
        $this->assertSame(
            '<input type="text" id="loginform-login" name="LoginForm[login]" dirname="test.dir">',
            Text::widget()->for(new LoginForm(), 'login')->dirname('test.dir')->render(),
        );
    }

    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        Text::widget()->for(new LoginForm(), 'login')->dirname('')->render();
    }

    public function testGetValidatorMatchRegularExpression(): void
    {
        $this->assertSame(
            '<input type="text" id="validatorform-matchregular" name="ValidatorForm[matchregular]" pattern="\w+">',
            Text::widget()->for(new ValidatorForm(), 'matchregular')->render(),
        );
    }

    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="text" id="validatorform-maxlength" name="ValidatorForm[maxlength]" maxlength="50">',
            Text::widget()->for(new ValidatorForm(), 'maxlength')->render(),
        );
    }

    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="text" id="validatorform-minlength" name="ValidatorForm[minlength]" minlength="15">',
            Text::widget()->for(new ValidatorForm(), 'minlength')->render(),
        );
    }

    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="text" id="validatorform-required" name="ValidatorForm[required]" required>',
            Text::widget()->for(new ValidatorForm(), 'required')->render(),
        );
    }

    public function testImmutability(): void
    {
        $text = Text::widget();
        $this->assertNotSame($text, $text->dirname('test.dir'));
        $this->assertNotSame($text, $text->maxlength(0));
        $this->assertNotSame($text, $text->placeholder(''));
        $this->assertNotSame($text, $text->pattern(''));
        $this->assertNotSame($text, $text->readOnly());
        $this->assertNotSame($text, $text->size(0));
    }

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="text" id="loginform-login" name="LoginForm[login]" maxlength="10">',
            Text::widget()->for(new LoginForm(), 'login')->maxlength(10)->render(),
        );
    }

    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="text" id="loginform-login" name="LoginForm[login]" minlength="4">',
            Text::widget()->for(new LoginForm(), 'login')->minlength(4)->render(),
        );
    }

    public function testPattern(): void
    {
        $this->assertSame(
            '<input type="text" id="loginform-login" name="LoginForm[login]" pattern="[A-Za-z]">',
            Text::widget()->for(new LoginForm(), 'login')->pattern('[A-Za-z]')->render(),
        );
    }

    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="text" id="loginform-login" name="LoginForm[login]" placeholder="PlaceHolder Text">',
            Text::widget()->for(new LoginForm(), 'login')->placeholder('PlaceHolder Text')->render(),
        );
    }

    public function testReadOnly(): void
    {
        $this->assertSame(
            '<input type="text" id="loginform-login" name="LoginForm[login]" readonly>',
            Text::widget()->for(new LoginForm(), 'login')->readOnly()->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="text" id="loginform-login" name="LoginForm[login]">',
            Text::widget()->for(new LoginForm(), 'login')->render(),
        );
    }

    public function testSize(): void
    {
        $this->assertSame(
            '<input type="text" id="loginform-login" name="LoginForm[login]" size="10">',
            Text::widget()->for(new LoginForm(), 'login')->size(10)->render(),
        );
    }

    public function testValue(): void
    {
        $formModel = new LoginForm();

        // Value `null`.
        $formModel->setAttribute('string', null);
        $this->assertSame(
            '<input type="text" id="loginform-login" name="LoginForm[login]">',
            Text::widget()->for($formModel, 'login')->render(),
        );

        // Value string `hello`.
        $formModel->setAttribute('string', 'hello');
        $this->assertSame(
            '<input type="text" id="loginform-login" name="LoginForm[login]">',
            Text::widget()->for($formModel, 'login')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Text widget must be a string or null value.');
        Text::widget()->for(new TypeForm(), 'array')->render();
    }
}
