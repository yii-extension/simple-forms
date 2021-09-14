<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Radio;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;

final class RadioTest extends TestCase
{
    public function testEnClosedByLabelWithFalse(): void
    {
        $this->assertSame(
            '<input type="radio" id="typeform-int" name="TypeForm[int]" value="0">',
            Radio::widget()->config($this->model, 'int')->enclosedByLabel(false)->render(),
        );
    }

    public function testForceUncheckedValue(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="radio" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget()->config($this->model, 'int', ['forceUncheckedValue' => '0'])->render(),
        );
    }

    public function testForm(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]" value="0" form="form-id"> Int</label>',
            Radio::widget()->config($this->model, 'int')->form('form-id')->render(),
        );
    }

    public function testImmutability(): void
    {
        $radio = Radio::widget();
        $this->assertNotSame($radio, $radio->enclosedByLabel(false));
        $this->assertNotSame($radio, $radio->form(''));
        $this->assertNotSame($radio, $radio->label(''));
        $this->assertNotSame($radio, $radio->labelAttributes());
    }

    public function testLabelWithLabelAttributes(): void
    {
        $expected = <<<'HTML'
        <label class="test-class"><input type="radio" id="typeform-int" name="TypeForm[int]" value="0"> Label:</label>
        HTML;
        $html = Radio::widget()
            ->config($this->model, 'int')
            ->label('Label:')
            ->labelAttributes(['class' => 'test-class'])
            ->render();
        $this->assertSame($expected, $html);
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>',
            Radio::widget()->config($this->model, 'int')->render()
        );
    }

    public function testValues(): void
    {
        // value bool false
        $this->model->setAttribute('bool', false);
        $this->assertSame(
            '<label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>',
            Radio::widget()->config($this->model, 'bool')->render(),
        );

        // value bool true
        $this->model->setAttribute('bool', true);
        $this->assertSame(
            '<label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>',
            Radio::widget()->config($this->model, 'bool')->render(),
        );

        // value int 0
        $this->model->setAttribute('int', 0);
        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>',
            Radio::widget()->config($this->model, 'int')->render(),
        );

        // value int 1
        $this->model->setAttribute('int', 1);
        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>',
            Radio::widget()->config($this->model, 'int')->render(),
        );

        // value string '0'
        $this->model->setAttribute('string', '0');
        $this->assertSame(
            '<label><input type="radio" id="typeform-string" name="TypeForm[string]" value="0"> String</label>',
            Radio::widget()->config($this->model, 'string')->render(),
        );

        // value string '1'
        $this->model->setAttribute('string', '1');
        $this->assertSame(
            '<label><input type="radio" id="typeform-string" name="TypeForm[string]" value="1" checked> String</label>',
            Radio::widget()->config($this->model, 'string')->render(),
        );

        // value null
        $this->model->setAttribute('toNull', null);
        $this->assertSame(
            '<label><input type="radio" id="typeform-tonull" name="TypeForm[toNull]" value="0"> To Null</label>',
            Radio::widget()->config($this->model, 'toNull')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Radio widget requires a bool|float|int|string|null value.');
        $html = Radio::widget()->config($this->model, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
