<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Radio;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;

final class RadioTest extends TestCase
{
    public function testRender(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('terms', true);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
        HTML;
        $this->assertEquals($expected, Radio::widget()->config($model, 'terms')->run());
    }

    public function testLabel(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('terms', true);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> customLabel</label>
        HTML;
        $this->assertEquals($expected, Radio::widget()->config($model, 'terms')->label('customLabel')->run());
    }

    public function testLabelAttributes(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('terms', true);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[terms]" value="0"><label class="test-class"><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
        HTML;
        $this->assertEquals(
            $expected,
            Radio::widget()->config($model, 'terms')->labelAttributes(['class' => 'test-class'])->run()
        );
    }

    public function testUncheckValue(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('terms', true);

        $expected = <<<'HTML'
        <label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
        HTML;
        $this->assertEquals($expected, Radio::widget()->config($model, 'terms')->uncheckValue()->run());
    }

    public function testUnclosedByLabel(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('terms', true);

        $expected = <<<'HTML'
        <input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked>
        HTML;
        $this->assertEquals(
            $expected, Radio::widget()->config($model, 'terms')->unclosedByLabel()->uncheckValue()->run()
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value must be a bool|float|int|string|Stringable|null.');
        $html = Radio::widget()->config(new PersonalForm(), 'citys')->render();
    }
}
