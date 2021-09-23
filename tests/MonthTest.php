<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Month;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;

final class MonthTest extends TestCase
{
    private TypeForm $model;

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="month" id="typeform-string" name="TypeForm[string]" value>',
            Month::widget()->config($this->model, 'string')->render(),
        );
    }

    public function testValue(): void
    {
        // string '1996-12'
        $this->model->setAttribute('string', '1996-12');
        $this->assertSame(
            '<input type="month" id="typeform-string" name="TypeForm[string]" value="1996-12">',
            Month::widget()->config($this->model, 'string')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->model->setAttribute('array', []);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Month widget requires a string value.');
        $html = Month::widget()->config($this->model, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
