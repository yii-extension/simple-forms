<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Range;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Html;

final class RangeTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" autofocus oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->autofocus()->for(new PropertyType(), 'int')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" disabled oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->disabled()->for(new PropertyType(), 'int')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeNumber(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="range" id="validatorrules-number" name="ValidatorRules[number]" value="0" max="5" min="3" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="ValidatorRules[number]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new ValidatorRules(), 'number')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="range" id="validatorrules-required" name="ValidatorRules[required]" value="0" required oninput="i1.value=this.value">
        <output id="i1" name="i1" for="ValidatorRules[required]">0</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="range" id="id-test" name="PropertyType[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->for(new PropertyType(), 'int')->id('id-test')->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $range = Range::widget();
        $this->assertNotSame($range, $range->max(0));
        $this->assertNotSame($range, $range->min(0));
        $this->assertNotSame($range, $range->outputAttributes([]));
        $this->assertNotSame($range, $range->outputTag(''));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMax(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" max="8" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new PropertyType(), 'int')->max(8)->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMin(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 1]);
        $expected = <<<HTML
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" min="4" oninput="i2.value=this.value">
        <output id="i2" name="i2" for="PropertyType[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new PropertyType(), 'int')->min(4)->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="range" id="propertytype-int" name="name-test" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="name-test">0</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->for(new PropertyType(), 'int')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testOutputAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 2]);
        $expected = <<<HTML
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" oninput="i3.value=this.value">
        <output id="i3" class="test-class" name="i3" for="PropertyType[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->for(new PropertyType(), 'int')->outputAttributes(['class' => 'test-class'])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testOutputTag(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 3]);
        $expected = <<<HTML
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" oninput="i4.value=this.value">
        <p id="i4" name="i4" for="PropertyType[int]">0</p>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->for(new PropertyType(), 'int')->outputTag('p')->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testOutputTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The output tag name it cannot be empty value.');
        Range::widget()->for(new PropertyType(), 'int')->outputTag('')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" required oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new PropertyType(), 'int')->required()->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new PropertyType(), 'int')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabindex(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" tabindex="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new PropertyType(), 'int')->tabindex(1)->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string numeric `1`.
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="range" id="propertytype-string" name="PropertyType[string]" value="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[string]">1</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->for(new PropertyType(), 'string')->value('1')->render()
        );

        // Value int `1`.
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">1</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new PropertyType(), 'int')->value(1)->render());

        // Value `null`.
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new PropertyType(), 'int')->value(null)->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Range widget must be a numeric or null value.');
        Range::widget()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithForm(): void
    {
        $formModel = new PropertyType();

        // Value int `1`.
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $formModel->set('int', 1);
        $expected = <<<HTML
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">1</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for($formModel, 'int')->render());

        // Value string numeric `1`.
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $formModel->set('string', '1');
        $expected = <<<HTML
        <input type="range" id="propertytype-string" name="PropertyType[string]" value="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[string]">1</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for($formModel, 'string')->render());

        // Value `null`.
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $formModel->set('int', null);
        $expected = <<<HTML
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for($formModel, 'int')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="range" name="PropertyType[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new PropertyType(), 'int')->id(null)->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="range" id="propertytype-int" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new PropertyType(), 'int')->name(null)->render());
    }
}
