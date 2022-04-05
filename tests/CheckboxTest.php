<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Checkbox;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class CheckboxTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><label><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]" value="1" autofocus> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()->autofocus()->for(new PropertyType(), 'bool')->value(true)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testChecked(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><label><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]" value="1" checked> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()->checked()->for(new PropertyType(), 'bool')->value(true)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0" disabled><label><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]" value="1" disabled> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()->disabled()->for(new PropertyType(), 'bool')->value(true)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testEnclosedByLabel(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]" value="1">
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()->for(new PropertyType(), 'bool')->enclosedByLabel(false)->value(true)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="ValidatorRules[required]" value="0"><label><input type="checkbox" id="validatorrules-required" name="ValidatorRules[required]" required> Required</label>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Checkbox::widget()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><label><input type="checkbox" id="id-test" name="PropertyType[bool]" value="1"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()->for(new PropertyType(), 'bool')->id('id-test')->value(true)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $checkbox = Checkbox::widget();
        $this->assertNotSame($checkbox, $checkbox->checked(false));
        $this->assertNotSame($checkbox, $checkbox->enclosedByLabel(false));
        $this->assertNotSame($checkbox, $checkbox->label(''));
        $this->assertNotSame($checkbox, $checkbox->labelAttributes([]));
        $this->assertNotSame($checkbox, $checkbox->uncheckValue('0'));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLabelWithLabelAttributes(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><label class="test-class"><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]" value="1"> test-text-label</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()
                ->for(new PropertyType(), 'bool')
                ->label('test-text-label')
                ->labelAttributes(['class' => 'test-class'])
                ->value(true)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="name-test" value="0"><label><input type="checkbox" id="propertytype-bool" name="name-test" value="1"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()->for(new PropertyType(), 'bool')->name('name-test')->value(true)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><label><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]" value="1" required> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()->for(new PropertyType(), 'bool')->required()->value(true)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><label><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]" value="1"> Bool</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->for(new PropertyType(), 'bool')->value(true)->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabindex(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><label><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]" value="1" tabindex="1"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()->for(new PropertyType(), 'bool')->tabindex(1)->value(true)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="1"><label><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()->for(new PropertyType(), 'bool')->uncheckValue('1')->render(),
        );

        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><label><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()->for(new PropertyType(), 'bool')->uncheckValue(0)->render(),
        );

        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><label><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()->for(new PropertyType(), 'bool')->uncheckValue(false)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value bool `false`.
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><label><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]" value="0"> Bool</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->for(new PropertyType(), 'bool')->value(false)->render());

        // Value bool `true`.
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><label><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]" value="1" checked> Bool</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->checked()->for(new PropertyType(), 'bool')->value(true)->render());

        // Value int `0`.
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[int]" value="0"><label><input type="checkbox" id="propertytype-int" name="PropertyType[int]" value="0"> Int</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->for(new PropertyType(), 'int')->value(0)->render());

        // Value int `1`.
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[int]" value="0"><label><input type="checkbox" id="propertytype-int" name="PropertyType[int]" value="1" checked> Int</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->checked()->for(new PropertyType(), 'int')->value(1)->render());

        // Value string '0'.
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[string]" value="0"><label><input type="checkbox" id="propertytype-string" name="PropertyType[string]" value="0"> String</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->for(new PropertyType(), 'string')->value('0')->render());

        // Value string '1'.
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[string]" value="0"><label><input type="checkbox" id="propertytype-string" name="PropertyType[string]" value="1" checked> String</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()->checked()->for(new PropertyType(), 'string')->value('1')->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[int]" value="0"><label><input type="checkbox" id="propertytype-int" name="PropertyType[int]"> Int</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->for(new PropertyType(), 'int')->value(null)->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Checkbox widget value can not be an iterable or an object.');
        Checkbox::widget()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value bool `true`.
        $formModel->setValue('bool', true);

        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><label><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]" value="0"> Bool</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->for($formModel, 'bool')->value(false)->render());
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><label><input type="checkbox" id="propertytype-bool" name="PropertyType[bool]" value="1" checked> Bool</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->for($formModel, 'bool')->value(true)->render());

        // Value int `1`.
        $formModel->setValue('int', 1);

        $expected = <<<HTML
        <input type="hidden" name="PropertyType[int]" value="0"><label><input type="checkbox" id="propertytype-int" name="PropertyType[int]" value="0"> Int</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->for($formModel, 'int')->value(0)->render());
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[int]" value="0"><label><input type="checkbox" id="propertytype-int" name="PropertyType[int]" value="1" checked> Int</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->for($formModel, 'int')->value(1)->render());

        // Value string '1'.
        $formModel->setValue('string', '1');

        $expected = <<<HTML
        <input type="hidden" name="PropertyType[string]" value="0"><label><input type="checkbox" id="propertytype-string" name="PropertyType[string]" value="0"> String</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->for($formModel, 'string')->value('0')->render());
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[string]" value="0"><label><input type="checkbox" id="propertytype-string" name="PropertyType[string]" value="1" checked> String</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->for($formModel, 'string')->value('1')->render());

        // Value `null`.
        $formModel->setValue('int', null);

        $expected = <<<HTML
        <input type="hidden" name="PropertyType[int]" value="0"><label><input type="checkbox" id="propertytype-int" name="PropertyType[int]" value="1"> Int</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->for($formModel, 'int')->value('1')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[bool]" value="0"><label><input type="checkbox" name="PropertyType[bool]" value="1"> Bool</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()->for(new PropertyType(), 'bool')->id(null)->value(true)->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<label><input type="checkbox" id="propertytype-bool" value="1"> Bool</label>',
            Checkbox::widget()->for(new PropertyType(), 'bool')->name(null)->value(true)->render(),
        );
    }
}
