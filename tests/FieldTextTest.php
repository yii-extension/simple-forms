<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\LoginForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yii\Extension\Simple\Forms\Field;

final class FieldTextTest extends TestCase
{
    use TestTrait;

    public function testDirname(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" dirname="test.dir">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new LoginForm(), 'login', ['dirname' => 'test.dir'])->render(),
        );
    }

    public function testMaxLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" maxlength="10">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new LoginForm(), 'login', ['maxlength' => 10])->render(),
        );
    }

    public function testMinLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" minlength="4">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new LoginForm(), 'login', ['minlength' => 4])->render(),
        );
    }

    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" title="Only accepts uppercase and lowercase letters." pattern="[A-Za-z]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->text(
                    new LoginForm(),
                    'login',
                    ['pattern' => '[A-Za-z]', 'title' => 'Only accepts uppercase and lowercase letters.'])
                ->render()
        );
    }

    public function testPlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" placeholder="PlaceHolder Text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new LoginForm(), 'login', ['placeholder' => 'PlaceHolder Text'])->render(),
        );
    }

    public function testReadOnly(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" readonly>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new LoginForm(), 'login', ['readonly' => true])->render(),
        );
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->text(new LoginForm(), 'login')->render());
    }

    public function testSize(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" size="10">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new LoginForm(), 'login', ['size' => 10])

->render(),
        );
    }

    public function testValue(): void
    {
        $formModel = new LoginForm();

        // Value `null`.
        $formModel->setAttribute('login', null);
        $expected = <<<'HTML'
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->text($formModel, 'login')->render());

        // Value `string`.
        $formModel->setAttribute('login', 'joe');
        $expected = <<<'HTML'
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" value="joe">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->text($formModel, 'login')->render());
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Text widget must be a string or null value.');
        Field::widget()->text(new TypeForm(), 'array')->render();
    }
}
