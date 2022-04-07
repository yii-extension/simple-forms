<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Password;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class PasswordTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="password" id="propertytype-string" name="PropertyType[string]" autofocus>',
            Password::create()->autofocus()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="password" id="propertytype-string" name="PropertyType[string]" disabled>',
            Password::create()->disabled()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRegex(): void
    {
        $this->assertSame(
            '<input type="password" id="validatorrules-regex" name="ValidatorRules[regex]" pattern="\w+">',
            Password::create()->for(new ValidatorRules(), 'regex')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="password" id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50">',
            Password::create()->for(new ValidatorRules(), 'maxlength')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="password" id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15">',
            Password::create()->for(new ValidatorRules(), 'minlength')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="password" id="validatorrules-required" name="ValidatorRules[required]" required>',
            Password::create()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="password" id="id-test" name="PropertyType[string]">',
            Password::create()->for(new PropertyType(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $password = Password::create();
        $this->assertNotSame($password, $password->maxlength(0));
        $this->assertNotSame($password, $password->minlength(4));
        $this->assertNotSame($password, $password->pattern(''));
        $this->assertNotSame($password, $password->placeholder(''));
        $this->assertNotSame($password, $password->readonly());
        $this->assertNotSame($password, $password->size(0));
    }

    /**
     * @throws ReflectionException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="password" id="propertytype-string" name="PropertyType[string]" maxlength="16">',
            Password::create()->for(new PropertyType(), 'string')->maxlength(16)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="password" id="propertytype-string" name="PropertyType[string]" minlength="8">',
            Password::create()->for(new PropertyType(), 'string')->minlength(8)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="password" id="propertytype-string" name="name-test">',
            Password::create()->for(new PropertyType(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testPattern(): void
    {
        $expected = <<<HTML
        <input type="password" id="propertytype-string" name="PropertyType[string]" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
        HTML;
        $this->assertSame(
            $expected,
            Password::create()
                ->for(new PropertyType(), 'string')
                ->pattern('(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="password" id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text">',
            Password::create()->for(new PropertyType(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="password" id="propertytype-string" name="PropertyType[string]" readonly>',
            Password::create()->for(new PropertyType(), 'string')->readonly()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="password" id="propertytype-string" name="PropertyType[string]" required>',
            Password::create()->for(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="password" id="propertytype-string" name="PropertyType[string]">',
            Password::create()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testSize(): void
    {
        $this->assertSame(
            '<input type="password" id="propertytype-string" name="PropertyType[string]" size="3">',
            Password::create()->for(new PropertyType(), 'string')->size(3)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabIndex(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="password" id="propertytype-string" name="PropertyType[string]" tabindex="1">',
            Password::create()->for(new PropertyType(), 'string')->tabIndex(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value string `1234??`.
        $this->assertSame(
            '<input type="password" id="propertytype-string" name="PropertyType[string]" value="1234??">',
            Password::create()->for(new PropertyType(), 'string')->value('1234??')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="password" id="propertytype-string" name="PropertyType[string]">',
            Password::create()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password widget must be a string or null value.');
        Password::create()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithForm(): void
    {
        $formModel = new PropertyType();

        // Value string `1234??`.
        $formModel->setValue('string', '1234??');
        $this->assertSame(
            '<input type="password" id="propertytype-string" name="PropertyType[string]" value="1234??">',
            Password::create()->for($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->setValue('string', null);
        $this->assertSame(
            '<input type="password" id="propertytype-string" name="PropertyType[string]">',
            Password::create()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="password" name="PropertyType[string]">',
            Password::create()->for(new PropertyType(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="password" id="propertytype-string">',
            Password::create()->for(new PropertyType(), 'string')->name(null)->render(),
        );
    }
}
