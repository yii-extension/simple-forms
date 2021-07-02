<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Checkbox;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class CheckboxTest extends TestCase
{
    public function testLabelWithLabelAttributes(): void
    {
        $html = CheckBox::widget()
            ->config(new PersonalForm(), 'terms')
            ->label('customLabel')
            ->labelAttributes(['class' => 'labelClass'])
            ->render();
        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[terms]" value="0"><label class="labelClass"><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="0"> customLabel</label>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testRender(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('terms', true);

        $html = CheckBox::widget()->config($model, 'terms')->render();
        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testUnClosedByLabel(): void
    {
        $html = CheckBox::widget()->config(new PersonalForm(), 'terms')->unClosedByLabel()->render();
        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[terms]" value="0"><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="0">
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testUncheckValue(): void
    {
        $html = CheckBox::widget()->config(new PersonalForm(), 'terms')->uncheckValue()->render();
        $expected = <<<'HTML'
        <label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="0"> Terms</label>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testValueException(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('citys', [1, 2]);
        $html = CheckBox::widget()->config(new PersonalForm(), 'terms')->uncheckValue()->render();
        $expected = <<<'HTML'
        <label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="0"> Terms</label>
        HTML;
        $this->assertSame($expected, $html);
    }
}
