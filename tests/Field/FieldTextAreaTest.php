<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\ValidatorForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class FieldTextAreaTest extends TestCase
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
        <textarea id="typeform-string" name="TypeForm[string]" autofocus></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->autofocus()->textArea(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testCols(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" cols="20"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->textArea(new TypeForm(), 'string', ['cols()' => [20]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDirname(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" dirname="test.dir"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->textArea(new TypeForm(), 'string', ['dirname()' => ['test.dir']])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        Field::widget()->textArea(new TypeForm(), 'string', ['dirname()' => ['']])->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" disabled></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->disabled()->textArea(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-maxlength">Maxlength</label>
        <textarea id="validatorform-maxlength" name="ValidatorForm[maxlength]" maxlength="50"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->textArea(new ValidatorForm(), 'maxlength')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-minlength">Minlength</label>
        <textarea id="validatorform-minlength" name="ValidatorForm[minlength]" minlength="15"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->textArea(new ValidatorForm(), 'minlength')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">String</label>
        <textarea id="id-test" name="TypeForm[string]"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id('id-test')->textArea(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMaxLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" maxlength="100"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->textArea(new TypeForm(), 'string', ['maxLength()' => [100]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMinLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" minlength="20"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->textArea(new TypeForm(), 'string', ['minLength()' => [20]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="name-test"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name('name-test')->textArea(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testPlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->placeholder('PlaceHolder Text')->textArea(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testReadOnly(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" readonly></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->readonly()->textArea(new TypeForm(), 'string')->render(),
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
        <textarea id="typeform-string" name="TypeForm[string]" required></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->required()->textArea(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->textArea(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRows(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" rows="4"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->textArea(new TypeForm(), 'string', ['rows()' => [4]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" tabindex="1"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->tabIndex(1)->textArea(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValue(): void
    {
        // Value `null`.
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->textArea(new TypeForm(), 'string')->value(null)->render(),
        );

        // Value string `hello`.
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]">hello</textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->textArea(new TypeForm(), 'string')->value('hello')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('TextArea widget must be a string or null value.');
        Field::widget()->textArea(new TypeForm(), 'array')->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueWithForm(): void
    {
        $formModel = new TypeForm();

        // Value `null`.
        $formModel->setAttribute('string', null);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->textArea($formModel, 'string')->render(),
        );

        // Value string `hello`.
        $formModel->setAttribute('string', 'hello');
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]">hello</textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->textArea($formModel, 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWrap(): void
    {
        /** hard value */
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" wrap="hard"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->textArea(new TypeForm(), 'string', ['wrap()' => ['hard']])->render(),
        );

        /** soft value */
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" wrap="soft"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->textArea(new TypeForm(), 'string', ['wrap()' => ['soft']])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWrapException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid wrap value. Valid values are: hard, soft.');
        Field::widget()->textArea(new TypeForm(), 'string', ['wrap()' => ['exception']]);
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label>String</label>
        <textarea name="TypeForm[string]"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id(null)->textArea(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name(null)->textArea(new TypeForm(), 'string')->render(),
        );
    }
}
