<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Range;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;

final class RangeTest extends TestCase
{
    private TypeForm $model;

    public function testImmutability(): void
    {
        $range = Range::widget();
        $this->assertNotSame($range, $range->max(0));
        $this->assertNotSame($range, $range->min(0));
    }

    public function testMax(): void
    {
        $this->assertSame(
            '<input type="range" id="typeform-int" name="TypeForm[int]" value="0" max="8">',
            Range::widget()->config($this->model, 'int')->max(8)->render(),
        );
    }

    public function testMin(): void
    {
        $this->assertSame(
            '<input type="range" id="typeform-int" name="TypeForm[int]" value="0" min="4">',
            Range::widget()->config($this->model, 'int')->min(4)->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="range" id="typeform-int" name="TypeForm[int]" value="0">',
            Range::widget()->config($this->model, 'int')->render(),
        );
    }

    public function testValue(): void
    {
        // string value numeric `1`.
        $this->model->setAttribute('string', '1');
        $this->assertSame(
            '<input type="range" id="typeform-string" name="TypeForm[string]" value="1">',
            Range::widget()->config($this->model, 'string')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Range widget must be a numeric value.');
        Range::widget()->config($this->model, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
