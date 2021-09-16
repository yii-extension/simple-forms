<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class FieldMonthTest extends TestCase
{
    use TestTrait;

    private TypeForm $model;

    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="month" id="typeform-string" name="TypeForm[string]" value placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->config($this->model, 'string')->month()->render());
    }

    public function testValue(): void
    {
        // string '1996-12'
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="month" id="typeform-string" name="TypeForm[string]" value="1996-12" placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->model->setAttribute('string', '1996-12');
        $this->assertEqualsWithoutLE($expected, Field::widget()->config($this->model, 'string')->month()->render());
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Month widget requires a string value.');
        $html = Field::widget()->config($this->model, 'array')->month()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
