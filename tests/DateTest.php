<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Date;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class DateTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="date" id="propertytype-string" name="PropertyType[string]" autofocus>',
            Date::create()->autofocus()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="date" id="propertytype-string" name="PropertyType[string]" disabled>',
            Date::create()->disabled()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="date" id="validatorrules-required" name="ValidatorRules[required]" required>',
            Date::create()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="date" id="id-test" name="PropertyType[string]">',
            Date::create()->for(new PropertyType(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $date = Date::create();
        $this->assertNotSame($date, $date->max(''));
        $this->assertNotSame($date, $date->min(''));
        $this->assertNotSame($date, $date->readonly());
    }

    /**
     * @throws ReflectionException
     */
    public function testMax(): void
    {
        $this->assertSame(
            '<input type="date" id="propertytype-string" name="PropertyType[string]" max="1996-12-19">',
            Date::create()->for(new PropertyType(), 'string')->max('1996-12-19')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMin(): void
    {
        $this->assertSame(
            '<input type="date" id="propertytype-string" name="PropertyType[string]" min="1996-12-19">',
            Date::create()->for(new PropertyType(), 'string')->min('1996-12-19')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="date" id="propertytype-string" name="name-test">',
            Date::create()->for(new PropertyType(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="date" id="propertytype-string" name="PropertyType[string]" readonly>',
            Date::create()->for(new PropertyType(), 'string')->readonly()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="date" id="propertytype-string" name="PropertyType[string]" required>',
            Date::create()->for(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="date" id="propertytype-string" name="PropertyType[string]">',
            Date::create()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabIndex(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="date" id="propertytype-string" name="PropertyType[string]" tabindex="1">',
            Date::create()->for(new PropertyType(), 'string')->tabIndex(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value string `2021-09-18`.
        $this->assertSame(
            '<input type="date" id="propertytype-string" name="PropertyType[string]" value="2021-09-18">',
            Date::create()->for(new PropertyType(), 'string')->value('2021-09-18')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="date" id="propertytype-string" name="PropertyType[string]">',
            Date::create()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Date widget requires a string or null value.');
        Date::create()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `2021-09-18`.
        $formModel->setValue('string', '2021-09-18');
        $this->assertSame(
            '<input type="date" id="propertytype-string" name="PropertyType[string]" value="2021-09-18">',
            Date::create()->for($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->setValue('string', null);
        $this->assertSame(
            '<input type="date" id="propertytype-string" name="PropertyType[string]">',
            Date::create()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="date" name="PropertyType[string]">',
            Date::create()->for(new PropertyType(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="date" id="propertytype-string">',
            Date::create()->for(new PropertyType(), 'string')->name(null)->render(),
        );
    }
}
