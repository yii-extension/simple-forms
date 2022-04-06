<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Number;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class NumberTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="number" id="propertytype-number" name="PropertyType[number]" autofocus>',
            Number::create()->autofocus()->for(new PropertyType(), 'number')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="number" id="propertytype-number" name="PropertyType[number]" disabled>',
            Number::create()->disabled()->for(new PropertyType(), 'number')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeNumber(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="number" id="validatorrules-number" name="ValidatorRules[number]" value="0" max="5" min="3">',
            Number::create()->for(new ValidatorRules(), 'number')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <input type="number" id="validatorrules-numberrequired" name="ValidatorRules[numberRequired]" value="0" required>
        HTML;
        $this->assertSame(
            $expected,
            Number::create()->for(new ValidatorRules(), 'numberRequired')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="number" id="id-test" name="PropertyType[number]">',
            Number::create()->for(new PropertyType(), 'number')->id('id-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $number = Number::create();
        $this->assertNotSame($number, $number->max(0));
        $this->assertNotSame($number, $number->min(0));
        $this->assertNotSame($number, $number->placeholder(''));
        $this->assertNotSame($number, $number->readonly());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMax(): void
    {
        $this->assertSame(
            '<input type="number" id="propertytype-number" name="PropertyType[number]" max="8">',
            Number::create()->for(new PropertyType(), 'number')->max(8)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMin(): void
    {
        $this->assertSame(
            '<input type="number" id="propertytype-number" name="PropertyType[number]" min="4">',
            Number::create()->for(new PropertyType(), 'number')->min(4)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="number" id="propertytype-number" name="name-test">',
            Number::create()->for(new PropertyType(), 'number')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="number" id="propertytype-number" name="PropertyType[number]" placeholder="PlaceHolder Text">',
            Number::create()->for(new PropertyType(), 'number')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="number" id="propertytype-number" name="PropertyType[number]" readonly>',
            Number::create()->for(new PropertyType(), 'number')->readonly()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="number" id="propertytype-number" name="PropertyType[number]" required>',
            Number::create()->for(new PropertyType(), 'number')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="number" id="propertytype-number" name="PropertyType[number]">',
            Number::create()->for(new PropertyType(), 'number')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="number" id="propertytype-number" name="PropertyType[number]" tabindex="1">',
            Number::create()->for(new PropertyType(), 'number')->tabIndex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // value int `1`.
        $this->assertSame(
            '<input type="number" id="propertytype-int" name="PropertyType[int]" value="1">',
            Number::create()->for(new PropertyType(), 'int')->value(1)->render(),
        );

        // Value string numeric `1`.
        $this->assertSame(
            '<input type="number" id="propertytype-string" name="PropertyType[string]" value="1">',
            Number::create()->for(new PropertyType(), 'string')->value('1')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="number" id="propertytype-int" name="PropertyType[int]">',
            Number::create()->for(new PropertyType(), 'int')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Number widget must be a numeric or null value.');
        Number::create()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // value int `1`.
        $formModel->setValue('int', 1);
        $this->assertSame(
            '<input type="number" id="propertytype-int" name="PropertyType[int]" value="1">',
            Number::create()->for($formModel, 'int')->render(),
        );

        // Value string numeric `1`.
        $formModel->setValue('string', '1');
        $this->assertSame(
            '<input type="number" id="propertytype-string" name="PropertyType[string]" value="1">',
            Number::create()->for($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->setValue('int', null);
        $this->assertSame(
            '<input type="number" id="propertytype-int" name="PropertyType[int]" value="0">',
            Number::create()->for($formModel, 'int')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="number" name="PropertyType[number]">',
            Number::create()->for(new PropertyType(), 'number')->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="number" id="propertytype-number">',
            Number::create()->for(new PropertyType(), 'number')->name(null)->render(),
        );
    }
}
