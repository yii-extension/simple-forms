<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class FieldDateTest extends TestCase
{
    use TestTrait;

    private TypeForm $model;

    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-todate">To Date</label>
        <input type="date" id="typeform-todate" name="TypeForm[toDate]" value>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'toDate')->date()->render(),
        );
    }

    public function testValue(): void
    {
        // string '2021-09-18'
        $expected = <<<HTML
        <div>
        <label for="typeform-todate">To Date</label>
        <input type="date" id="typeform-todate" name="TypeForm[toDate]" value>
        </div>
        HTML;
        $this->model->setAttribute('string', '2021-09-18');
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'toDate')->date()->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Date widget requires a string value.');
        $html = Field::widget()->config($this->model, 'array')->date()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
