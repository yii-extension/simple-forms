<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Telephone;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class TelephoneTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" autofocus>',
            Telephone::widget()->autofocus()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" disabled>',
            Telephone::widget()->disabled()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRegex(): void
    {
        $this->assertSame(
            '<input type="tel" id="validatorrules-regex" name="ValidatorRules[regex]" pattern="\w+">',
            Telephone::widget()->for(new ValidatorRules(), 'regex')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="tel" id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50">',
            Telephone::widget()->for(new ValidatorRules(), 'maxlength')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="tel" id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15">',
            Telephone::widget()->for(new ValidatorRules(), 'minlength')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="tel" id="validatorrules-required" name="ValidatorRules[required]" required>',
            Telephone::widget()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="tel" id="id-test" name="PropertyType[string]">',
            Telephone::widget()->for(new PropertyType(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $telephone = Telephone::widget();
        $this->assertNotSame($telephone, $telephone->maxlength(0));
        $this->assertNotSame($telephone, $telephone->minlength(0));
        $this->assertNotSame($telephone, $telephone->pattern(''));
        $this->assertNotSame($telephone, $telephone->placeholder(''));
        $this->assertNotSame($telephone, $telephone->readonly());
        $this->assertNotSame($telephone, $telephone->size(0));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" maxlength="10">',
            Telephone::widget()->for(new PropertyType(), 'string')->maxlength(10)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" minlength="4">',
            Telephone::widget()->for(new PropertyType(), 'string')->minlength(4)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="name-test">',
            Telephone::widget()->for(new PropertyType(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPattern(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" pattern="[789][0-9]{9}">',
            Telephone::widget()->for(new PropertyType(), 'string')->pattern('[789][0-9]{9}')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text">',
            Telephone::widget()->for(new PropertyType(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" readonly>',
            Telephone::widget()->for(new PropertyType(), 'string')->readonly()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" required>',
            Telephone::widget()->for(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]">',
            Telephone::widget()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSize(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" size="20">',
            Telephone::widget()->for(new PropertyType(), 'string')->size(20)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `+71234567890`.
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" value="+71234567890">',
            Telephone::widget()->for(new PropertyType(), 'string')->value('+71234567890')->render(),
        );

        // Value numeric string `71234567890`.
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" value="71234567890">',
            Telephone::widget()->for(new PropertyType(), 'string')->value('71234567890')->render(),
        );

        // Value integer `71234567890`.
        $this->assertSame(
            '<input type="tel" id="propertytype-int" name="PropertyType[int]" value="71234567890">',
            Telephone::widget()->for(new PropertyType(), 'int')->value(71234567890)->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]">',
            Telephone::widget()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Telephone widget must be a string, numeric or null.');
        Telephone::widget()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `+71234567890`.
        $formModel->setValue('string', '+71234567890');
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" value="+71234567890">',
            Telephone::widget()->for($formModel, 'string')->render(),
        );

        // Value numeric string `71234567890`.
        $formModel->setValue('string', '71234567890');
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]" value="71234567890">',
            Telephone::widget()->for($formModel, 'string')->render(),
        );

        // Value integer `71234567890`.
        $formModel->setValue('int', 71234567890);
        $this->assertSame(
            '<input type="tel" id="propertytype-int" name="PropertyType[int]" value="71234567890">',
            Telephone::widget()->for($formModel, 'int')->render(),
        );

        // Value `null`.
        $formModel->setValue('string', null);
        $this->assertSame(
            '<input type="tel" id="propertytype-string" name="PropertyType[string]">',
            Telephone::widget()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="tel" name="PropertyType[string]">',
            Telephone::widget()->for(new PropertyType(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="tel" id="propertytype-string">',
            Telephone::widget()->for(new PropertyType(), 'string')->name(null)->render(),
        );
    }
}
