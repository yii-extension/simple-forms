<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class FieldTextAreaTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]" autofocus></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->autofocus()->textArea(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testCols(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]" cols="20"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->textArea(new PropertyType(), 'string', ['cols()' => [20]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDirname(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]" dirname="test.dir"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->textArea(new PropertyType(), 'string', ['dirname()' => ['test.dir']])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        Field::create()->textArea(new PropertyType(), 'string', ['dirname()' => ['']])->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]" disabled></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->disabled()->textArea(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-maxlength">Maxlength</label>
        <textarea id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->textArea(new ValidatorRules(), 'maxlength')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-minlength">Minlength</label>
        <textarea id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->textArea(new ValidatorRules(), 'minlength')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">String</label>
        <textarea id="id-test" name="PropertyType[string]"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->id('id-test')->textArea(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMaxLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]" maxlength="100"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->textArea(new PropertyType(), 'string', ['maxLength()' => [100]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMinLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]" minlength="20"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->textArea(new PropertyType(), 'string', ['minLength()' => [20]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="name-test"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->name('name-test')->textArea(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testPlaceholder(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->placeholder('PlaceHolder Text')->textArea(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testReadonly(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]" readonly></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->textArea(new PropertyType(), 'string')->readonly()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]" required></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->required()->textArea(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->textArea(new PropertyType(), 'string')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testRows(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]" rows="4"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->textArea(new PropertyType(), 'string', ['rows()' => [4]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]" tabindex="1"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->tabIndex(1)->textArea(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value string `hello`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]">hello</textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->textArea(new PropertyType(), 'string')->value('hello')->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->textArea(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('TextArea widget must be a string or null value.');
        Field::create()->textArea(new PropertyType(), 'array')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithForm(): void
    {
        $formModel = new PropertyType();

        // Value string `hello`.
        $formModel->setValue('string', 'hello');
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]">hello</textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->textArea($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->setValue('string', null);
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->textArea($formModel, 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWrap(): void
    {
        /** hard value */
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]" wrap="hard"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->textArea(new PropertyType(), 'string', ['wrap()' => ['hard']])->render(),
        );

        /** soft value */
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string" name="PropertyType[string]" wrap="soft"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->textArea(new PropertyType(), 'string', ['wrap()' => ['soft']])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWrapException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid wrap value. Valid values are: hard, soft.');
        Field::create()->textArea(new PropertyType(), 'string', ['wrap()' => ['exception']]);
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label>String</label>
        <textarea name="PropertyType[string]"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->id(null)->textArea(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <textarea id="propertytype-string"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->name(null)->textArea(new PropertyType(), 'string')->render(),
        );
    }
}
