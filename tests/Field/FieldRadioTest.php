<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class FieldRadioTest extends TestCase
{
    use TestTrait;

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testAnyLabel(): void
    {
        $expected = <<<HTML
        <div>
        <input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->radio(new TypeForm(), 'bool', ['enclosedByLabel()' => [false]])
                ->value(true)
                ->withoutLabel()
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" autofocus> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->autofocus()->radio(new TypeForm(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" disabled> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->disabled()->radio(new TypeForm(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testEnclosedByLabel(): void
    {
        // Enclosed by label `false`.
        $expected = <<<HTML
        <div>
        <label for="typeform-bool">Bool</label>
        <input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new TypeForm(), 'bool', ['enclosedByLabel()' => [false]])->value(true)->render(),
        );

        // Enclosed by label `true`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio(new TypeForm(), 'bool')->value(true)->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testEnclosedByLabelWithLabelAttributes(): void
    {
        // Enclosed by label `false` with label attributes.
        $expected = <<<HTML
        <div>
        <label class="test-class" for="typeform-bool">Bool</label>
        <input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->labelClass('test-class')
                ->radio(new TypeForm(), 'bool', ['enclosedByLabel()' => [false]])
                ->value(true)
                ->render(),
        );

        // Enclosed by label `true` with label attributes.
        $expected = <<<HTML
        <div>
        <label class="test-class"><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->labelClass('test-class')->radio(new TypeForm(), 'bool')->value(true)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testEnclosedByLabelCustomText(): void
    {
        // Enclosed by label `false` with custom text.
        $expected = <<<HTML
        <div>
        <label for="typeform-bool">test-text-label</label>
        <input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->label('test-text-label')
                ->radio(new TypeForm(), 'bool', ['enclosedByLabel()' => [false]])
                ->value(true)
                ->render(),
        );

        // Enclosed by label `true` with custom text
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1"> test-text-label</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->label('test-text-label')->radio(new TypeForm(), 'bool')->value(true)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="id-test" name="TypeForm[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id('id-test')->radio(new TypeForm(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testLabelWithLabelAttributes(): void
    {
        $expected = <<<HTML
        <div>
        <label class="test-class"><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Label:</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->radio(new TypeForm(), 'int')
                ->label('Label:')
                ->labelAttributes(['class' => 'test-class'])
                ->value(1)
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testLabelClass(): void
    {
        $expected = <<<HTML
        <div>
        <label class="test-class"><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->labelClass('test-class')->radio(new TypeForm(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-int" name="name-test" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name('name-test')->radio(new TypeForm(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" required> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new TypeForm(), 'int')->required()->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio(new TypeForm(), 'int')->value(1)->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testTabindex(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" tabindex="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new TypeForm(), 'int')->tabindex(1)->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new TypeForm(), 'bool', ['uncheckValue()' => ['0']])->value(true)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValue(): void
    {
        // Value bool `false`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio(new TypeForm(), 'bool')->value(false)->render());

        // Value bool `true`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new TypeForm(), 'bool', ['checked()' => [true]])->value(true)->render(),
        );

        // Value int `0`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new TypeForm(), 'int')->value(0)->render()
        );

        // Value int `1`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new TypeForm(), 'int', ['checked()' => [true]])->value(1)->render(),
        );

        // Value string `inactive`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-string" name="TypeForm[string]" value="inactive"> String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new TypeForm(), 'string')->value('inactive')->render(),
        );

        // Value string `active`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-string" name="TypeForm[string]" value="active" checked> String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio(new TypeForm(), 'string', ['checked()' => [true]])->value('active')->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-int" name="TypeForm[int]"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio(new TypeForm(), 'int')->value(null)->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Radio widget value can not be an iterable or an object.');
        Field::widget()->radio(new TypeForm(), 'array')->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value bool `true`.
        $formModel->setAttribute('bool', true);

        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio($formModel, 'bool')->value(false)->render());
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio($formModel, 'bool')->value(true)->render());

        // Value int `1`.
        $formModel->setAttribute('int', 1);

        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio($formModel, 'int')->value(0)->render());
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio($formModel, 'int')->value(1)->render());

        // Value string `inactive`.
        $formModel->setAttribute('string', 'active');

        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-string" name="TypeForm[string]" value="inactive"> String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio($formModel, 'string')->value('inactive')->render(),
        );
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-string" name="TypeForm[string]" value="active" checked> String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radio($formModel, 'string')->value('active')->render(),
        );

        // Value `null`.
        $formModel->setAttribute('int', null);
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-int" name="TypeForm[int]"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->radio($formModel, 'int')->value(null)->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" name="TypeForm[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id(null)->radio(new TypeForm(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" id="typeform-int" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name(null)->radio(new TypeForm(), 'int')->value(1)->render(),
        );
    }
}
