<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class FieldCheckBoxTest extends TestCase
{
    use TestTrait;

    private TypeForm $model;

    public function testAnyLabel(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0">
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'bool')
            ->checkbox([], false)
            ->label(['label' => false])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEnclosedByLabel(): void
    {
        // Enclosed by label `false`
        $expected = <<<'HTML'
        <div>
        <label for="typeform-bool">Bool</label>
        <input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'bool')->checkbox([], false)->render(),
        );

        // Enclosed by label `true`
        $expected = <<<'HTML'
        <div>
        <label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'bool')->checkbox([], true)->render(),
        );
    }

    public function testEnclosedByLabelWithLabelAttributes(): void
    {
        // Enclosed by label `false` with label attributes
        $expected = <<<'HTML'
        <div>
        <label class="test-class" for="typeform-bool">Bool</label>
        <input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0">
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'bool')
            ->checkbox([], false)
            ->label(['class' => 'test-class'])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);

        // Enclosed by label `true` with label attributes
        $expected = <<<'HTML'
        <div>
        <label class="test-class"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'bool')
            ->checkbox(['labelAttributes' => ['class' => 'test-class']])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEnclosedByLabelCustomText(): void
    {
        // Enclosed by label `false` with custom text
        $expected = <<<'HTML'
        <div>
        <label for="typeform-bool">test-text-label</label>
        <input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0">
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'bool')
            ->checkbox([], false)
            ->label(['label' => 'test-text-label'])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);

        // Enclosed by label `true` with custom text
        $expected = <<<'HTML'
        <div>
        <label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0"> test-text-label</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'bool')->checkbox(['label' => 'test-text-label'])->render(),
        );
    }

    public function testForceUncheckedValue(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'bool')->checkbox(['forceUncheckedValue' => '0'])->render(),
        );
    }

    public function testForm(): void
    {
        $expected = <<<'HTML'
        <div>
        <label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0" form="form-id"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'bool')->checkbox(['form' => 'form-id'])->render(),
        );
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'bool')->checkbox()->render(),
        );
    }

    public function testValues(): void
    {
        // value bool false
        $this->model->setAttribute('bool', false);
        $expected = <<<'HTML'
        <div>
        <label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'bool')->checkbox()->render(),
        );

        // value bool true
        $this->model->setAttribute('bool', true);
        $expected = <<<'HTML'
        <div>
        <label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'bool')->checkbox()->render(),
        );

        // value int 0
        $this->model->setAttribute('int', 0);
        $expected = <<<'HTML'
        <div>
        <label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'int')->checkbox()->render(),
        );

        // value int 1
        $this->model->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div>
        <label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'int')->checkbox()->render(),
        );

        // value string '0'
        $this->model->setAttribute('string', '0');
        $expected = <<<'HTML'
        <div>
        <label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="0"> String</label>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->checkbox()->render(),
        );

        // value string '1'
        $this->model->setAttribute('string', '1');
        $expected = <<<'HTML'
        <div>
        <label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="1" checked> String</label>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->checkbox()->render(),
        );

        // value null
        $this->model->setAttribute('toNull', null);
        $expected = <<<'HTML'
        <div>
        <label><input type="checkbox" id="typeform-tonull" name="TypeForm[toNull]" value="0"> To Null</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'toNull')->checkbox()->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Checkbox widget requires a bool|float|int|string|null value.');
        Field::widget()->config($this->model, 'array')->checkbox()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
