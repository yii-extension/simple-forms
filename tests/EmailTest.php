<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Email;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class EmailTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" autofocus>',
            Email::create()->autofocus()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" disabled>',
            Email::create()->disabled()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRegex(): void
    {
        $this->assertSame(
            '<input type="email" id="validatorrules-regex" name="ValidatorRules[regex]" pattern="\w+">',
            Email::create()->for(new ValidatorRules(), 'regex')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="email" id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50">',
            Email::create()->for(new ValidatorRules(), 'maxlength')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="email" id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15">',
            Email::create()->for(new ValidatorRules(), 'minlength')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="email" id="validatorrules-required" name="ValidatorRules[required]" required>',
            Email::create()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="email" id="id-test" name="PropertyType[string]">',
            Email::create()->for(new PropertyType(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $email = Email::create();
        $this->assertNotSame($email, $email->maxlength(0));
        $this->assertNotSame($email, $email->minlength(0));
        $this->assertNotSame($email, $email->multiple(true));
        $this->assertNotSame($email, $email->pattern(''));
        $this->assertNotSame($email, $email->placeholder(''));
        $this->assertNotSame($email, $email->size(0));
    }

    /**
     * @throws ReflectionException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" maxlength="10">',
            Email::create()->for(new PropertyType(), 'string')->maxlength(10)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" minlength="4">',
            Email::create()->for(new PropertyType(), 'string')->minlength(4)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMultiple(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" value="email1@example.com">',
            Email::create()
                ->for(new PropertyType(), 'string')
                ->multiple(false)
                ->value('email1@example.com')
                ->render(),
        );

        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" value="email1@example.com;email2@example.com;" multiple>',
            Email::create()
                ->for(new PropertyType(), 'string')
                ->multiple()
                ->value('email1@example.com;email2@example.com;')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="name-test">',
            Email::create()->for(new PropertyType(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <input type="email" id="propertytype-string" name="PropertyType[string]" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}">
        HTML;
        $html = Email::create()
            ->for(new PropertyType(), 'string')
            ->pattern('[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}')
            ->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws ReflectionException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text">',
            Email::create()->for(new PropertyType(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" readonly>',
            Email::create()->for(new PropertyType(), 'string')->readonly()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" required>',
            Email::create()->for(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]">',
            Email::create()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testSize(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" size="20">',
            Email::create()->for(new PropertyType(), 'string')->size(20)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabIndex(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" tabindex="1">',
            Email::create()->for(new PropertyType(), 'string')->tabindex(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value string `email1@example.com;`.
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" value="email1@example.com;">',
            Email::create()->for(new PropertyType(), 'string')->value('email1@example.com;')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]">',
            Email::create()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email widget must be a string or null value.');
        Email::create()->for(new PropertyType(), 'int')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `email1@example.com;`.
        $formModel->setValue('string', 'email1@example.com;');
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" value="email1@example.com;">',
            Email::create()->for($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->setValue('string', null);
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]">',
            Email::create()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="email" name="PropertyType[string]">',
            Email::create()->for(new PropertyType(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string">',
            Email::create()->for(new PropertyType(), 'string')->name(null)->render(),
        );
    }
}
