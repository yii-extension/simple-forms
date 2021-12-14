<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\LoginForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class FieldPasswordTest extends TestCase
{
    use TestTrait;

    public function testAutofocus(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-password">Password</label>
        <input type="password" id="loginform-password" name="LoginForm[password]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->password(new LoginForm(), 'password')->autofocus()->render(),
        );
    }

    public function testDisabled(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-password">Password</label>
        <input type="password" id="loginform-password" name="LoginForm[password]" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->password(new LoginForm(), 'password')->disabled()->render(),
        );
    }

    public function testMaxLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-password">Password</label>
        <input type="password" id="loginform-password" name="LoginForm[password]" maxlength="16">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->password(new LoginForm(), 'password', ['maxlength' => 16])->render(),
        );
    }

    public function testMinLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-password">Password</label>
        <input type="password" id="loginform-password" name="LoginForm[password]" minlength="8">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->password(new LoginForm(), 'password', ['minlength' => 8])->render(),
        );
    }

    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-password">Password</label>
        <input type="password" id="loginform-password" name="LoginForm[password]" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->password(
                    new LoginForm(),
                    'password',
                    [
                        'pattern' => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}',
                        'title' => 'Must contain at least one number and one uppercase and lowercase letter, and at ' .
                        'least 8 or more characters.',
                    ]
                )
                ->render()
        );
    }

    public function testPlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-password">Password</label>
        <input type="password" id="loginform-password" name="LoginForm[password]" placeholder="PlaceHolder Text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->password(new LoginForm(), 'password')->placeHolder('PlaceHolder Text')->render(),
        );
    }

    public function testReadOnly(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-password">Password</label>
        <input type="password" id="loginform-password" name="LoginForm[password]" readonly>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->password(new LoginForm(), 'password')->readonly()->render(),
        );
    }

    public function testRequired(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="password" id="typeform-string" name="TypeForm[string]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->password(new TypeForm(), 'string')->required()->render(),
        );
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-password">Password</label>
        <input type="password" id="loginform-password" name="LoginForm[password]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->password(new LoginForm(), 'password')->render(),
        );
    }

    public function testTabIndex(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="loginform-password">Password</label>
        <input type="password" id="loginform-password" name="LoginForm[password]" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->password(new LoginForm(), 'password')->tabIndex(1)->render(),
        );
    }

    public function testValue(): void
    {
        $formModel = new LoginForm();

        // Value `null`.
        $formModel->setAttribute('password', null);
        $expected = <<<'HTML'
        <div>
        <label for="loginform-password">Password</label>
        <input type="password" id="loginform-password" name="LoginForm[password]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->password($formModel, 'password')->render());

        // Value string `1234??`.
        $formModel->setAttribute('password', '1234??');
        $expected = <<<'HTML'
        <div>
        <label for="loginform-password">Password</label>
        <input type="password" id="loginform-password" name="LoginForm[password]" value="1234??">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->password($formModel, 'password')->render());
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password widget must be a string or null value.');
        Field::widget()->password(new TypeForm(), 'array')->render();
    }
}
