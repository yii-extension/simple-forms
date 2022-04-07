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

final class FieldTelephoneTest extends TestCase
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
        <input type="tel" id="propertytype-string" name="PropertyType[string]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->autofocus()->telephone(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="tel" id="propertytype-string" name="PropertyType[string]" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->disabled()->telephone(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRegex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-regex">Regex</label>
        <input type="tel" id="validatorrules-regex" name="ValidatorRules[regex]" pattern="\w+">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->telephone(new ValidatorRules(), 'regex')->render(),
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
        <input type="tel" id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->telephone(new ValidatorRules(), 'maxlength')->render()
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-minlength">Minlength</label>
        <input type="tel" id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->telephone(new ValidatorRules(), 'minlength')->render()
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-required">Required</label>
        <input type="tel" id="validatorrules-required" name="ValidatorRules[required]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->telephone(new ValidatorRules(), 'required')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">String</label>
        <input type="tel" id="id-test" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->id('id-test')->telephone(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMaxLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="tel" id="propertytype-string" name="PropertyType[string]" maxlength="10">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->telephone(new PropertyType(), 'string', ['maxlength()' => [10]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMinLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="tel" id="propertytype-string" name="PropertyType[string]" minlength="4">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->telephone(new PropertyType(), 'string', ['minlength()' => [4]])->render(),
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
        <input type="tel" id="propertytype-string" name="name-test">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->name('name-test')->telephone(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="tel" id="propertytype-string" name="PropertyType[string]" pattern="[789][0-9]{9}">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->telephone(new PropertyType(), 'string', ['pattern()' => ['[789][0-9]{9}']])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testPlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="tel" id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->placeholder('PlaceHolder Text')->telephone(new PropertyType(), 'string')->render(),
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
        <input type="tel" id="propertytype-string" name="PropertyType[string]" readonly>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->telephone(new PropertyType(), 'string')->readonly()->render(),
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
        <input type="tel" id="propertytype-string" name="PropertyType[string]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->required()->telephone(new PropertyType(), 'string')->render(),
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
        <input type="tel" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->telephone(new PropertyType(), 'string')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="tel" id="propertytype-string" name="PropertyType[string]" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->tabIndex(1)->telephone(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value string `+71234567890`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="tel" id="propertytype-string" name="PropertyType[string]" value="+71234567890">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->telephone(new PropertyType(), 'string')->value('+71234567890')->render(),
        );

        // Value numeric string `71234567890`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="tel" id="propertytype-string" name="PropertyType[string]" value="71234567890">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->telephone(new PropertyType(), 'string')->value('71234567890')->render(),
        );

        // Value integer `71234567890`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-int">Int</label>
        <input type="tel" id="propertytype-int" name="PropertyType[int]" value="71234567890">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->telephone(new PropertyType(), 'int')->value(71234567890)->render(),
        );

        // Value `null`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="tel" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->telephone(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Telephone widget must be a string, numeric or null.');
        Field::create()->telephone(new PropertyType(), 'array')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `+71234567890`.
        $formModel->setValue('string', '+71234567890');
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="tel" id="propertytype-string" name="PropertyType[string]" value="+71234567890">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->telephone($formModel, 'string')->render());

        // Value numeric string `71234567890`.
        $formModel->setValue('string', '71234567890');
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="tel" id="propertytype-string" name="PropertyType[string]" value="71234567890">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->telephone($formModel, 'string')->render());

        // Value integer `71234567890`.
        $formModel->setValue('int', 71234567890);
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-int">Int</label>
        <input type="tel" id="propertytype-int" name="PropertyType[int]" value="71234567890">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->telephone($formModel, 'int')->render());

        // Value `null`.
        $formModel->setValue('string', null);
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="tel" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->telephone($formModel, 'string')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label>String</label>
        <input type="tel" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->id(null)->telephone(new PropertyType(), 'string')->render(),
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
        <input type="tel" id="propertytype-string">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->name(null)->telephone(new PropertyType(), 'string')->render(),
        );
    }
}
