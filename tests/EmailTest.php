<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Email;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class EmailTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" autofocus>',
            Email::widget()->autofocus()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" disabled>',
            Email::widget()->disabled()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRegex(): void
    {
        $this->assertSame(
            '<input type="email" id="validatorrules-regex" name="ValidatorRules[regex]" pattern="\w+">',
            Email::widget()->for(new ValidatorRules(), 'regex')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="email" id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50">',
            Email::widget()->for(new ValidatorRules(), 'maxlength')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="email" id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15">',
            Email::widget()->for(new ValidatorRules(), 'minlength')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="email" id="validatorrules-required" name="ValidatorRules[required]" required>',
            Email::widget()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="email" id="id-test" name="PropertyType[string]">',
            Email::widget()->for(new PropertyType(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $email = Email::widget();
        $this->assertNotSame($email, $email->maxlength(0));
        $this->assertNotSame($email, $email->minlength(0));
        $this->assertNotSame($email, $email->multiple(true));
        $this->assertNotSame($email, $email->pattern(''));
        $this->assertNotSame($email, $email->placeholder(''));
        $this->assertNotSame($email, $email->size(0));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" maxlength="10">',
            Email::widget()->for(new PropertyType(), 'string')->maxlength(10)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" minlength="4">',
            Email::widget()->for(new PropertyType(), 'string')->minlength(4)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMultiple(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" value="email1@example.com">',
            Email::widget()
                ->for(new PropertyType(), 'string')
                ->multiple(false)
                ->value('email1@example.com')
                ->render(),
        );

        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" value="email1@example.com;email2@example.com;" multiple>',
            Email::widget()
                ->for(new PropertyType(), 'string')
                ->multiple()
                ->value('email1@example.com;email2@example.com;')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="name-test">',
            Email::widget()->for(new PropertyType(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <input type="email" id="propertytype-string" name="PropertyType[string]" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}">
        HTML;
        $html = Email::widget()
            ->for(new PropertyType(), 'string')
            ->pattern('[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}')
            ->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text">',
            Email::widget()->for(new PropertyType(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" readonly>',
            Email::widget()->for(new PropertyType(), 'string')->readonly()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" required>',
            Email::widget()->for(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]">',
            Email::widget()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSize(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" size="20">',
            Email::widget()->for(new PropertyType(), 'string')->size(20)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" tabindex="1">',
            Email::widget()->for(new PropertyType(), 'string')->tabindex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `email1@example.com;`.
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" value="email1@example.com;">',
            Email::widget()->for(new PropertyType(), 'string')->value('email1@example.com;')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]">',
            Email::widget()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email widget must be a string or null value.');
        Email::widget()->for(new PropertyType(), 'int')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `email1@example.com;`.
        $formModel->set('string', 'email1@example.com;');
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]" value="email1@example.com;">',
            Email::widget()->for($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->set('string', null);
        $this->assertSame(
            '<input type="email" id="propertytype-string" name="PropertyType[string]">',
            Email::widget()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="email" name="PropertyType[string]">',
            Email::widget()->for(new PropertyType(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="email" id="propertytype-string">',
            Email::widget()->for(new PropertyType(), 'string')->name(null)->render(),
        );
    }
}
