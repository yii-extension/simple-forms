<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Telephone;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class TelephoneTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" autofocus>',
            Telephone::create()->autofocus()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" disabled>',
            Telephone::create()->disabled()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRegex(): void
    {
        $this->assertSame(
            '<input type="tel" id="validatorrules-regex" name="ValidatorRules[regex]" pattern="\w+">',
            Telephone::create()->for(new ValidatorRules(), 'regex')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="tel" id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50">',
            Telephone::create()->for(new ValidatorRules(), 'maxlength')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="tel" id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15">',
            Telephone::create()->for(new ValidatorRules(), 'minlength')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="tel" id="validatorrules-required" name="ValidatorRules[required]" required>',
            Telephone::create()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="tel" id="id-test" name="PropertyType[string]">',
            Telephone::create()->for(new PropertyType(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $telephone = Telephone::create();
        $this->assertNotSame($telephone, $telephone->maxlength(0));
        $this->assertNotSame($telephone, $telephone->minlength(0));
        $this->assertNotSame($telephone, $telephone->pattern(''));
        $this->assertNotSame($telephone, $telephone->placeholder(''));
        $this->assertNotSame($telephone, $telephone->readonly());
        $this->assertNotSame($telephone, $telephone->size(0));
    }

    /**
     * @throws ReflectionException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" maxlength="10">',
            Telephone::create()->for(new PropertyType(), 'string')->maxlength(10)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" minlength="4">',
            Telephone::create()->for(new PropertyType(), 'string')->minlength(4)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="name-test">',
            Telephone::create()->for(new PropertyType(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testPattern(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" pattern="[789][0-9]{9}">',
            Telephone::create()->for(new PropertyType(), 'string')->pattern('[789][0-9]{9}')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text">',
            Telephone::create()->for(new PropertyType(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" readonly>',
            Telephone::create()->for(new PropertyType(), 'string')->readonly()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" required>',
            Telephone::create()->for(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]">',
            Telephone::create()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testSize(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" size="20">',
            Telephone::create()->for(new PropertyType(), 'string')->size(20)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value string `+71234567890`.
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" value="+71234567890">',
            Telephone::create()->for(new PropertyType(), 'string')->value('+71234567890')->render(),
        );

        // Value numeric string `71234567890`.
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" value="71234567890">',
            Telephone::create()->for(new PropertyType(), 'string')->value('71234567890')->render(),
        );

        // Value integer `71234567890`.
        $this->assertSame(
            '<input type="tel" id="propertytype-int" name="PropertyType[int]" value="71234567890">',
            Telephone::create()->for(new PropertyType(), 'int')->value(71234567890)->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]">',
            Telephone::create()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Telephone widget must be a string, numeric or null.');
        Telephone::create()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `+71234567890`.
        $formModel->setValue('string', '+71234567890');
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" value="+71234567890">',
            Telephone::create()->for($formModel, 'string')->render(),
        );

        // Value numeric string `71234567890`.
        $formModel->setValue('string', '71234567890');
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" value="71234567890">',
            Telephone::create()->for($formModel, 'string')->render(),
        );

        // Value integer `71234567890`.
        $formModel->setValue('int', 71234567890);
        $this->assertSame(
            '<input type="tel" id="propertytype-int" name="PropertyType[int]" value="71234567890">',
            Telephone::create()->for($formModel, 'int')->render(),
        );

        // Value `null`.
        $formModel->setValue('string', null);
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]">',
            Telephone::create()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="tel" name="PropertyType[string]">',
            Telephone::create()->for(new PropertyType(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string">',
            Telephone::create()->for(new PropertyType(), 'string')->name(null)->render(),
        );
    }
}
