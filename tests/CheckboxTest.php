<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Checkbox;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class CheckboxTest extends TestCase
{
    public function testEnclosedByLabelFalse(): void
    {
        $html = CheckBox::widget()->config(new PersonalForm(), 'terms')->enclosedByLabel(false)->render();
        $expected = <<<'HTML'
        <input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="0">
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testLabelWithLabelAttributes(): void
    {
        $html = CheckBox::widget()
            ->config(new PersonalForm(), 'terms')
            ->label('customLabel')
            ->labelAttributes(['class' => 'labelClass'])
            ->render();
        $expected = <<<'HTML'
        <label class="labelClass"><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="0"> customLabel</label>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testRender(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('terms', true);

        $html = CheckBox::widget()->config($model, 'terms')->render();
        $expected = <<<'HTML'
        <label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value must be a bool|float|int|string|Stringable|null.');
        $html = CheckBox::widget()->config(new PersonalForm(), 'citys')->render();
    }
}
