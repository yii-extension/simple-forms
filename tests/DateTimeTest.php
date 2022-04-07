<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\DateTime;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class DateTimeTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" autofocus>',
            DateTime::create()->autofocus()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" disabled>',
            DateTime::create()->disabled()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="datetime" id="validatorrules-required" name="ValidatorRules[required]" required>',
            DateTime::create()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="datetime" id="id-test" name="PropertyType[string]">',
            DateTime::create()->for(new PropertyType(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $dateTime = DateTime::create();
        $this->assertNotSame($dateTime, $dateTime->max(''));
        $this->assertNotSame($dateTime, $dateTime->min(''));
        $this->assertNotSame($dateTime, $dateTime->readonly());
    }

    /**
     * @throws ReflectionException
     */
    public function testMax(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" max="1990-12-31T23:59:60Z">',
            DateTime::create()->for(new PropertyType(), 'string')->max('1990-12-31T23:59:60Z')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMin(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" min="1990-12-31T23:59:60Z">',
            DateTime::create()->for(new PropertyType(), 'string')->min('1990-12-31T23:59:60Z')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="name-test">',
            DateTime::create()->for(new PropertyType(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" readonly>',
            DateTime::create()->for(new PropertyType(), 'string')->readonly()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" required>',
            DateTime::create()->for(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]">',
            DateTime::create()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabindex(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" tabindex="1">',
            DateTime::create()->for(new PropertyType(), 'string')->tabindex(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value string `2021-09-18`.
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" value="2021-09-18T23:59:00">',
            DateTime::create()->for(new PropertyType(), 'string')->value('2021-09-18T23:59:00')->render(),
        );

        // Value `null`
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]">',
            DateTime::create()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('DateTime widget requires a string or null value.');
        DateTime::create()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValuWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `2021-09-18`.
        $formModel->setValue('string', '2021-09-18T23:59:00');
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" value="2021-09-18T23:59:00">',
            DateTime::create()->for($formModel, 'string')->render(),
        );

        // Value `null`
        $formModel->setValue('string', null);
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]">',
            DateTime::create()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="datetime" name="PropertyType[string]">',
            DateTime::create()->for(new PropertyType(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string">',
            DateTime::create()->for(new PropertyType(), 'string')->name(null)->render(),
        );
    }
}
