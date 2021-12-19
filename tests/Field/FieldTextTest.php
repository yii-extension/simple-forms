<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\LoginForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\ValidatorForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class FieldTextTest extends TestCase
{
    use TestTrait;

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->autofocus()->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDirname(): void
    {
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" dirname="test.dir">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new LoginForm(), 'login', ['dirname()' => ['test.dir']])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        Field::widget()->text(new LoginForm(), 'login', ['dirname()' => ['']])->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->disabled()->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorMatchRegularExpression(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-matchregular">Matchregular</label>
        <input type="text" id="validatorform-matchregular" name="ValidatorForm[matchregular]" pattern="\w+">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->text(new ValidatorForm(), 'matchregular')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-maxlength">Maxlength</label>
        <input type="text" id="validatorform-maxlength" name="ValidatorForm[maxlength]" maxlength="50">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->text(new ValidatorForm(), 'maxlength')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-minlength">Minlength</label>
        <input type="text" id="validatorform-minlength" name="ValidatorForm[minlength]" minlength="15">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->text(new ValidatorForm(), 'minlength')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-required">Required</label>
        <input type="text" id="validatorform-required" name="ValidatorForm[required]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->text(new ValidatorForm(), 'required')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">String</label>
        <input type="text" id="id-test" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id('id-test')->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMaxLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" maxlength="10">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new LoginForm(), 'login', ['maxlength()' => [10]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMinLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" minlength="4">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new LoginForm(), 'login', ['minlength()' => [4]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="name-test">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name('name-test')->text(new LoginForm(), 'login')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testPattern(): void
    {
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" title="Only accepts uppercase and lowercase letters." pattern="[A-Za-z]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->text(new LoginForm(), 'login', ['pattern()' => ['[A-Za-z]']])
                ->title('Only accepts uppercase and lowercase letters.')
                ->render()
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testPlaceholder(): void
    {
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" placeholder="PlaceHolder Text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->placeHolder('PlaceHolder Text')->text(new LoginForm(), 'login')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testReadOnly(): void
    {
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" readonly>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->attribute('readonly', true)->text(new LoginForm(), 'login')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->required()->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->text(new LoginForm(), 'login')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testSize(): void
    {
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" size="10">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new LoginForm(), 'login', ['size()' => [10]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->tabIndex(1)->text(new LoginForm(), 'login')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValue(): void
    {
        // Value `null`.
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new LoginForm(), 'login')->value(null)->render(),
        );

        // Value string `joe`.
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" value="joe">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new LoginForm(), 'login')->value('joe')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Text widget must be a string or null value.');
        Field::widget()->text(new TypeForm(), 'array')->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueWithForm(): void
    {
        $formModel = new LoginForm();

        // Value `null`.
        $formModel->setAttribute('login', null);
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->text($formModel, 'login')->render());

        // Value string `joe`.
        $formModel->setAttribute('login', 'joe');
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]" value="joe">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->text($formModel, 'login')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label>Login</label>
        <input type="text" name="LoginForm[login]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id(null)->text(new LoginForm(), 'login')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name(null)->text(new LoginForm(), 'login')->render(),
        );
    }
}