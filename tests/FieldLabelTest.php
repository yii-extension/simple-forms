<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class FieldLabelTest extends TestCase
{
    use TestTrait;

    private PersonalForm $model;

    public function testAnyLabel(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="text" id="personalform-email" name="PersonalForm[email]" value>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'email')->label(['label' => false])->render(),
        );
    }

    public function testLabelCustom(): void
    {
        $expected = <<<'HTML'
        <div>
        <label class="test-class" for="personalform-email">Email:</label>
        <input type="text" id="personalform-email" name="PersonalForm[email]" value>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'email')
            ->label(['class' => 'test-class', 'label' => 'Email:'])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="personalform-email">Email</label>
        <input type="text" id="personalform-email" name="PersonalForm[email]" value>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->config($this->model, 'email')->render());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new PersonalForm();
    }
}
