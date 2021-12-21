<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Range;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\ValidatorForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Html;

final class RangeTest extends TestCase
{
    use TestTrait;

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testAutofocus(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" autofocus oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->autofocus()->for(new TypeForm(), 'int')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDisabled(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" disabled oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->disabled()->for(new TypeForm(), 'int')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeNumber(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="range" id="validatorform-number" name="ValidatorForm[number]" value="0" max="5" min="3" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="ValidatorForm[number]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new ValidatorForm(), 'number')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="range" id="id-test" name="TypeForm[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new TypeForm(), 'int')->id('id-test')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
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
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMax(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" max="8" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new TypeForm(), 'int')->max(8)->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMin(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 1]);
        $expected = <<<HTML
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" min="4" oninput="i2.value=this.value">
        <output id="i2" name="i2" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new TypeForm(), 'int')->min(4)->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="range" id="typeform-int" name="name-test" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="name-test">0</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->for(new TypeForm(), 'int')->name('name-test')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testOutputAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 2]);
        $expected = <<<HTML
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i3.value=this.value">
        <output id="i3" class="test-class" name="i3" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->for(new TypeForm(), 'int')->outputAttributes(['class' => 'test-class'])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testOutputTag(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 3]);
        $expected = <<<HTML
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i4.value=this.value">
        <p id="i4" name="i4" for="TypeForm[int]">0</p>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new TypeForm(), 'int')->outputTag('p')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testOutputTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The output tag name it cannot be empty value.');
        Range::widget()->for(new TypeForm(), 'int')->outputTag('')->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRequired(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" required oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new TypeForm(), 'int')->required()->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new TypeForm(), 'int')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testTabindex(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" tabindex="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new TypeForm(), 'int')->tabindex(1)->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        // Value string numeric `1`.
        $expected = <<<HTML
        <input type="range" id="typeform-string" name="TypeForm[string]" value="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[string]">1</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new TypeForm(), 'string')->value('1')->render());

        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        // Value int `1`.
        $expected = <<<HTML
        <input type="range" id="typeform-int" name="TypeForm[int]" value="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">1</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new TypeForm(), 'int')->value(1)->render());

        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        // Value `null`.
        $expected = <<<HTML
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new TypeForm(), 'int')->value(null)->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Range widget must be a numeric or null value.');
        Range::widget()->for(new TypeForm(), 'array')->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueWithForm(): void
    {
        $formModel = new TypeForm();

        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        // Value int `1`.
        $formModel->setAttribute('int', 1);

        $expected = <<<HTML
        <input type="range" id="typeform-int" name="TypeForm[int]" value="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">1</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for($formModel, 'int')->render());

        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        // Value string numeric `1`.
        $formModel->setAttribute('string', '1');

        $expected = <<<HTML
        <input type="range" id="typeform-string" name="TypeForm[string]" value="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[string]">1</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for($formModel, 'string')->render());

        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        // Value `null`.
        $formModel->setAttribute('int', null);

        $expected = <<<HTML
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for($formModel, 'int')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="range" name="TypeForm[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new TypeForm(), 'int')->id(null)->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="range" id="typeform-int" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for(new TypeForm(), 'int')->name(null)->render());
    }
}
