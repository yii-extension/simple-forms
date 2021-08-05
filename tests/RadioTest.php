<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Radio;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\PersonalForm;

final class RadioTest extends TestCase
{
    public function testEnclosedByLabelFalse(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('terms', true);

        $expected = <<<'HTML'
        <input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked>
        HTML;
        $this->assertEquals(
            $expected, Radio::widget()->config($model, 'terms')->enclosedByLabel(false)->render()
        );
    }

    public function testLabel(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('terms', true);

        $expected = <<<'HTML'
        <label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> customLabel</label>
        HTML;
        $this->assertEquals($expected, Radio::widget()->config($model, 'terms')->label('customLabel')->render());
    }

    public function testLabelAttributes(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('terms', true);

        $expected = <<<'HTML'
        <label class="test-class"><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
        HTML;
        $this->assertEquals(
            $expected,
            Radio::widget()->config($model, 'terms')->labelAttributes(['class' => 'test-class'])->render()
        );
    }

    public function testRender(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('terms', true);

        $expected = <<<'HTML'
        <label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
        HTML;
        $this->assertEquals($expected, Radio::widget()->config($model, 'terms')->render());
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value must be a bool|float|int|string|Stringable|null.');
        $html = Radio::widget()->config(new PersonalForm(), 'citys')->render();
    }
}
