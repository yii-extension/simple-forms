<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class FieldRadioTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAnyLabel(): void
    {
        $expected = <<<HTML
        <div>
        <input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->radio(new PropertyType(), 'bool', ['enclosedByLabel()' => [false]])
                ->value(true)
                ->label(null)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1" autofocus> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->autofocus()->radio(new PropertyType(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testChecked(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1" checked> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new PropertyType(), 'int', ['checked()' => []])->value(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1" disabled> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->disabled()->radio(new PropertyType(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testEnclosedByLabel(): void
    {
        // Enclosed by label `false`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-bool">Bool</label>
        <input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new PropertyType(), 'bool', ['enclosedByLabel()' => [false]])->value(true)->render(),
        );

        // Enclosed by label `true`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio(new PropertyType(), 'bool')->value(true)->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testEnclosedByLabelWithLabelAttributes(): void
    {
        // Enclosed by label `false` with label attributes.
        $expected = <<<HTML
        <div>
        <label class="test-class" for="propertytype-bool">Bool</label>
        <input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->labelClass('test-class')
                ->radio(new PropertyType(), 'bool', ['enclosedByLabel()' => [false]])
                ->value(true)
                ->render(),
        );

        // Enclosed by label `true` with label attributes.
        $expected = <<<HTML
        <div>
        <label class="test-class"><input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->radio(new PropertyType(), 'bool', ['labelAttributes()' => [['class' => 'test-class']]])
                ->value(true)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testEnclosedByLabelCustomText(): void
    {
        // Enclosed by label `false` with custom text.
        $expected = <<<HTML
        <div>
        <label for="propertytype-bool">test-text-label</label>
        <input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->label('test-text-label')
                ->radio(new PropertyType(), 'bool', ['enclosedByLabel()' => [false]])
                ->value(true)
                ->render(),
        );

        // Enclosed by label `true` with custom text
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="1"> test-text-label</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new PropertyType(), 'bool', ['label()' => ['test-text-label']])->value(true)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="validatorrules-required" name="ValidatorRules[required]" required> Required</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="id-test" name="PropertyType[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id('id-test')->radio(new PropertyType(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLabelWithLabelAttributes(): void
    {
        $expected = <<<HTML
        <div>
        <label class="test-class"><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1"> Label:</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->radio(
                    new PropertyType(),
                    'int',
                    ['label()' => ['Label:'], 'labelAttributes()' => [['class' => 'test-class']]]
                )
                ->value(1)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLabelClass(): void
    {
        $expected = <<<HTML
        <div>
        <label class="test-class"><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->radio(new PropertyType(), 'int', ['labelAttributes()' => [['class' => 'test-class']]])
                ->value(1)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-int" name="name-test" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name('name-test')->radio(new PropertyType(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1" required> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new PropertyType(), 'int')->required()->value(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio(new PropertyType(), 'int')->value(1)->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabindex(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1" tabindex="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new PropertyType(), 'int')->tabindex(1)->value(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="PropertyType[bool]" value="0"><label><input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new PropertyType(), 'bool', ['uncheckValue()' => ['0']])->value(true)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value bool `false`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="0"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio(new PropertyType(), 'bool')->value(false)->render());

        // Value bool `true`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="1" checked> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new PropertyType(), 'bool', ['checked()' => [true]])->value(true)->render(),
        );

        // Value int `0`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="0"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new PropertyType(), 'int')->value(0)->render()
        );

        // Value int `1`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1" checked> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new PropertyType(), 'int', ['checked()' => [true]])->value(1)->render(),
        );

        // Value string `inactive`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-string" name="PropertyType[string]" value="inactive"> String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new PropertyType(), 'string')->value('inactive')->render(),
        );

        // Value string `active`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-string" name="PropertyType[string]" value="active" checked> String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new PropertyType(), 'string', ['checked()' => [true]])->value('active')->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-int" name="PropertyType[int]"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio(new PropertyType(), 'int')->value(null)->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Radio widget value can not be an iterable or an object.');
        Field::widget()->radio(new PropertyType(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value bool `true`.
        $formModel->set('bool', true);

        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="0"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio($formModel, 'bool')->value(false)->render());
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-bool" name="PropertyType[bool]" value="1" checked> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio($formModel, 'bool')->value(true)->render());

        // Value int `1`.
        $formModel->set('int', 1);

        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="0"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio($formModel, 'int')->value(0)->render());
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-int" name="PropertyType[int]" value="1" checked> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio($formModel, 'int')->value(1)->render());

        // Value string `inactive`.
        $formModel->set('string', 'active');

        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-string" name="PropertyType[string]" value="inactive"> String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio($formModel, 'string')->value('inactive')->render(),
        );
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-string" name="PropertyType[string]" value="active" checked> String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio($formModel, 'string')->value('active')->render(),
        );

        // Value `null`.
        $formModel->set('int', null);
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-int" name="PropertyType[int]"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio($formModel, 'int')->value(null)->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" name="PropertyType[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id(null)->radio(new PropertyType(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="propertytype-int" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name(null)->radio(new PropertyType(), 'int')->value(1)->render(),
        );
    }
}
