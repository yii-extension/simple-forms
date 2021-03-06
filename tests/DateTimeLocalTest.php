<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\DateTimeLocal;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class DateTimeLocalTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="propertytype-string" name="PropertyType[string]" autofocus>',
            DateTimeLocal::create()->autofocus()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="propertytype-string" name="PropertyType[string]" disabled>',
            DateTimeLocal::create()->disabled()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="validatorrules-required" name="ValidatorRules[required]" required>',
            DateTimeLocal::create()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="id-test" name="PropertyType[string]">',
            DateTimeLocal::create()->for(new PropertyType(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $dateTimeLocal = DateTimeLocal::create();
        $this->assertNotSame($dateTimeLocal, $dateTimeLocal->max(''));
        $this->assertNotSame($dateTimeLocal, $dateTimeLocal->min(''));
        $this->assertNotSame($dateTimeLocal, $dateTimeLocal->readonly());
    }

    /**
     * @throws ReflectionException
     */
    public function testMax(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="propertytype-string" name="PropertyType[string]" max="1985-04-12T23:20:50.52">',
            DateTimeLocal::create()->for(new PropertyType(), 'string')->max('1985-04-12T23:20:50.52')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMin(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="propertytype-string" name="PropertyType[string]" min="1985-04-12T23:20:50.52">',
            DateTimeLocal::create()->for(new PropertyType(), 'string')->min('1985-04-12T23:20:50.52')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="propertytype-string" name="name-test">',
            DateTimeLocal::create()->for(new PropertyType(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="propertytype-string" name="PropertyType[string]" readonly>',
            DateTimeLocal::create()->for(new PropertyType(), 'string')->readonly()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="propertytype-string" name="PropertyType[string]" required>',
            DateTimeLocal::create()->for(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="propertytype-string" name="PropertyType[string]">',
            DateTimeLocal::create()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabindex(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="propertytype-string" name="PropertyType[string]" tabindex="1">',
            DateTimeLocal::create()->for(new PropertyType(), 'string')->tabindex(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value string `2021-09-18`.
        $this->assertSame(
            '<input type="datetime-local" id="propertytype-string" name="PropertyType[string]" value="2021-09-18T23:59:00">',
            DateTimeLocal::create()->for(new PropertyType(), 'string')->value('2021-09-18T23:59:00')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="datetime-local" id="propertytype-string" name="PropertyType[string]">',
            DateTimeLocal::create()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('DateTimeLocal widget requires a string or null value.');
        DateTimeLocal::create()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `2021-09-18`.
        $formModel->setValue('string', '2021-09-18T23:59:00');
        $this->assertSame(
            '<input type="datetime-local" id="propertytype-string" name="PropertyType[string]" value="2021-09-18T23:59:00">',
            DateTimeLocal::create()->for($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->setValue('string', null);
        $this->assertSame(
            '<input type="datetime-local" id="propertytype-string" name="PropertyType[string]">',
            DateTimeLocal::create()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="datetime-local" name="PropertyType[string]">',
            DateTimeLocal::create()->for(new PropertyType(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="propertytype-string">',
            DateTimeLocal::create()->for(new PropertyType(), 'string')->name(null)->render(),
        );
    }
}
