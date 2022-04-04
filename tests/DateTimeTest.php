<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\DateTime;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class DateTimeTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" autofocus>',
            DateTime::widget()->autofocus()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" disabled>',
            DateTime::widget()->disabled()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="datetime" id="validatorrules-required" name="ValidatorRules[required]" required>',
            DateTime::widget()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="datetime" id="id-test" name="PropertyType[string]">',
            DateTime::widget()->for(new PropertyType(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $dateTime = DateTime::widget();
        $this->assertNotSame($dateTime, $dateTime->max(''));
        $this->assertNotSame($dateTime, $dateTime->min(''));
        $this->assertNotSame($dateTime, $dateTime->readonly());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMax(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" max="1990-12-31T23:59:60Z">',
            DateTime::widget()->for(new PropertyType(), 'string')->max('1990-12-31T23:59:60Z')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMin(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" min="1990-12-31T23:59:60Z">',
            DateTime::widget()->for(new PropertyType(), 'string')->min('1990-12-31T23:59:60Z')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="name-test">',
            DateTime::widget()->for(new PropertyType(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" readonly>',
            DateTime::widget()->for(new PropertyType(), 'string')->readonly()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" required>',
            DateTime::widget()->for(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]">',
            DateTime::widget()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabindex(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" tabindex="1">',
            DateTime::widget()->for(new PropertyType(), 'string')->tabindex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `2021-09-18`.
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" value="2021-09-18T23:59:00">',
            DateTime::widget()->for(new PropertyType(), 'string')->value('2021-09-18T23:59:00')->render(),
        );

        // Value `null`
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]">',
            DateTime::widget()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('DateTime widget requires a string or null value.');
        DateTime::widget()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValuWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `2021-09-18`.
        $formModel->set('string', '2021-09-18T23:59:00');
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]" value="2021-09-18T23:59:00">',
            DateTime::widget()->for($formModel, 'string')->render(),
        );

        // Value `null`
        $formModel->set('string', null);
        $this->assertSame(
            '<input type="datetime" id="propertytype-string" name="PropertyType[string]">',
            DateTime::widget()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="datetime" name="PropertyType[string]">',
            DateTime::widget()->for(new PropertyType(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="datetime" id="propertytype-string">',
            DateTime::widget()->for(new PropertyType(), 'string')->name(null)->render(),
        );
    }
}
