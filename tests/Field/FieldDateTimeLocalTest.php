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

final class FieldDateTimeLocalTest extends TestCase
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
        <input type="datetime-local" id="propertytype-string" name="PropertyType[string]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->autofocus()->dateTimeLocal(new PropertyType(), 'string')->render(),
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
        <input type="datetime-local" id="propertytype-string" name="PropertyType[string]" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->dateTimeLocal(new PropertyType(), 'string')->disabled()->render(),
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
        <input type="datetime-local" id="validatorrules-required" name="ValidatorRules[required]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->dateTimeLocal(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">String</label>
        <input type="datetime-local" id="id-test" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->dateTimeLocal(new PropertyType(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMax(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="datetime-local" id="propertytype-string" name="PropertyType[string]" max="1985-04-12T23:20:50.52">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->dateTimeLocal(new PropertyType(), 'string', ['max()' => ['1985-04-12T23:20:50.52']])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMin(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="datetime-local" id="propertytype-string" name="PropertyType[string]" min="1985-04-12T23:20:50.52">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->dateTimeLocal(new PropertyType(), 'string', ['min()' => ['1985-04-12T23:20:50.52']])
                ->render(),
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
        <input type="datetime-local" id="propertytype-string" name="name=test">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->dateTimeLocal(new PropertyType(), 'string')->name('name=test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testReadonly(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="datetime-local" id="propertytype-string" name="PropertyType[string]" readonly>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->dateTimeLocal(new PropertyType(), 'string')->readonly()->render(),
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
        <input type="datetime-local" id="propertytype-string" name="PropertyType[string]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->dateTimeLocal(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="datetime-local" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->dateTimeLocal(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabindex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="datetime-local" id="propertytype-string" name="PropertyType[string]" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->dateTimeLocal(new PropertyType(), 'string')->tabindex(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value string `2021-09-18`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="datetime-local" id="propertytype-string" name="PropertyType[string]" value="2021-09-18T23:59:00">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->dateTimeLocal(new PropertyType(), 'string')->value('2021-09-18T23:59:00')->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="datetime-local" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->dateTimeLocal(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('DateTimeLocal widget requires a string or null value.');
        Field::create()->dateTimeLocal(new PropertyType(), 'array')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValuWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `2021-09-18`.
        $formModel->setValue('string', '2021-09-18T23:59:00');
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="datetime-local" id="propertytype-string" name="PropertyType[string]" value="2021-09-18T23:59:00">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->dateTimeLocal($formModel, 'string')->render());

        // Value `null`.
        $formModel->setValue('string', null);
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="datetime-local" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->dateTimeLocal(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label>String</label>
        <input type="datetime-local" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->dateTimeLocal(new PropertyType(), 'string')->id(null)->render(),
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
        <input type="datetime-local" id="propertytype-string">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->dateTimeLocal(new PropertyType(), 'string')->name(null)->render(),
        );
    }
}
