<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Radio;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class RadioTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1" autofocus> Int</label>',
            Radio::create()->autofocus()->for(new PropertyType(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testChecked(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1" checked> Int</label>',
            Radio::create()->checked()->for(new PropertyType(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1" disabled> Int</label>',
            Radio::create()->disabled()->for(new PropertyType(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testEnClosedByLabelWithFalse(): void
    {
        $this->assertSame(
            '<input type="radio" id="propertytype-int" name="PropertyType[int]" value="1">',
            Radio::create()->for(new PropertyType(), 'int')->enclosedByLabel(false)->value(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <label><input type="radio" id="validatorrules-required" name="ValidatorRules[required]" required> Required</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::create()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="id-test" name="PropertyType[int]" value="1"> Int</label>',
            Radio::create()->for(new PropertyType(), 'int')->id('id-test')->value(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $radio = Radio::create();
        $this->assertNotSame($radio, $radio->checked(false));
        $this->assertNotSame($radio, $radio->enclosedByLabel(false));
        $this->assertNotSame($radio, $radio->label(''));
        $this->assertNotSame($radio, $radio->labelAttributes());
        $this->assertNotSame($radio, $radio->uncheckValue(0));
    }

    /**
     * @throws ReflectionException
     */
    public function testLabelWithLabelAttributes(): void
    {
        $expected = <<<HTML
        <label class="test-class"><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1"> Label:</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::create()
                ->for(new PropertyType(), 'int')
                ->label('Label:')
                ->labelAttributes(['class' => 'test-class'])
                ->value(1)
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="propertytype-int" name="name-test" value="1"> Int</label>',
            Radio::create()->for(new PropertyType(), 'int')->name('name-test')->value(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1" required> Int</label>',
            Radio::create()->for(new PropertyType(), 'int')->required()->value(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1"> Int</label>',
            Radio::create()->for(new PropertyType(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabIndex(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1" tabindex="1"> Int</label>',
            Radio::create()->for(new PropertyType(), 'int')->tabindex(1)->value(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[int]" value="0"><label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1"> Int</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::create()->for(new PropertyType(), 'int')->uncheckValue(0)->value(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value bool `false`.
        $this->assertSame(
            '<label><input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="0"> Bool</label>',
            Radio::create()->for(new PropertyType(), 'bool')->value(false)->render(),
        );

        // Value bool `true`.
        $this->assertSame(
            '<label><input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="1" checked> Bool</label>',
            Radio::create()->checked()->for(new PropertyType(), 'bool')->value(true)->render(),
        );

        // Value int `0`.
        $this->assertSame(
            '<label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="0"> Int</label>',
            Radio::create()->for(new PropertyType(), 'int')->value(0)->render(),
        );

        // Value int `1`.
        $this->assertSame(
            '<label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1" checked> Int</label>',
            Radio::create()->checked()->for(new PropertyType(), 'int')->value(1)->render(),
        );

        // Value string `inactive`.
        $this->assertSame(
            '<label><input type="radio" id="propertytype-string" name="PropertyType[string]" value="inactive"> String</label>',
            Radio::create()->for(new PropertyType(), 'string')->value('inactive')->render(),
        );

        // Value string `active`.
        $expected = <<<HTML
        <label><input type="radio" id="propertytype-string" name="PropertyType[string]" value="active" checked> String</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::create()->checked()->for(new PropertyType(), 'string')->value('active')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<label><input type="radio" id="propertytype-int" name="PropertyType[int]"> Int</label>',
            Radio::create()->for(new PropertyType(), 'int')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Radio widget value can not be an iterable or an object.');
        Radio::create()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value bool `true`.
        $formModel->setValue('bool', true);

        $this->assertSame(
            '<label><input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="0"> Bool</label>',
            Radio::create()->for($formModel, 'bool')->value(false)->render(),
        );
        $this->assertSame(
            '<label><input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="1" checked> Bool</label>',
            Radio::create()->for($formModel, 'bool')->value(true)->render(),
        );

        // Value int `1`.
        $formModel->setValue('int', 1);

        $this->assertSame(
            '<label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="0"> Int</label>',
            Radio::create()->for($formModel, 'int')->value(0)->render(),
        );
        $this->assertSame(
            '<label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1" checked> Int</label>',
            Radio::create()->for($formModel, 'int')->value(1)->render(),
        );

        // Value string `active`.
        $formModel->setValue('string', 'active');

        $this->assertSame(
            '<label><input type="radio" id="propertytype-string" name="PropertyType[string]" value="inactive"> String</label>',
            Radio::create()->for($formModel, 'string')->value('inactive')->render()
        );

        $expected = <<<HTML
        <label><input type="radio" id="propertytype-string" name="PropertyType[string]" value="active" checked> String</label>
        HTML;
        $this->assertSame($expected, Radio::create()->for($formModel, 'string')->value('active')->render());

        // Value `null`.
        $formModel->setValue('int', 'null');

        $this->assertSame(
            '<label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1"> Int</label>',
            Radio::create()->for($formModel, 'int')->value(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $this->assertEqualsWithoutLE(
            '<label><input type="radio" name="PropertyType[int]" value="1"> Int</label>',
            Radio::create()->for(new PropertyType(), 'int')->id(null)->value(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $this->assertEqualsWithoutLE(
            '<label><input type="radio" id="propertytype-int" value="1"> Int</label>',
            Radio::create()->for(new PropertyType(), 'int')->name(null)->value(1)->render(),
        );
    }
}
