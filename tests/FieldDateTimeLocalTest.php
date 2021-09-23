<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class FieldDateTimeLocalTest extends TestCase
{
    use TestTrait;

    private TypeForm $model;

    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="datetime-local" id="typeform-string" name="TypeForm[string]" value placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->datetimelocal()->render(),
        );
    }

    public function testValue(): void
    {
        // string '2021-09-18T23:59:00'
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="datetime-local" id="typeform-string" name="TypeForm[string]" value="2021-09-18T23:59:00" placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->model->setAttribute('string', '2021-09-18T23:59:00');
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->datetimelocal()->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('DateTimeLocal widget requires a string value.');
        $html = Field::widget()->config($this->model, 'array')->datetimelocal()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
