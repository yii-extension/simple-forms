<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Number;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;

final class NumberTest extends TestCase
{
    private TypeForm $model;

    public function testImmutability(): void
    {
        $number = Number::widget();
        $this->assertNotSame($number, $number->max(0));
        $this->assertNotSame($number, $number->min(0));
        $this->assertNotSame($number, $number->placeholder(''));
    }

    public function testMax(): void
    {
        $this->assertSame(
            '<input type="number" id="typeform-int" name="TypeForm[int]" value="0" max="8">',
            Number::widget()->config($this->model, 'int')->max(8)->render(),
        );
    }

    public function testMin(): void
    {
        $this->assertSame(
            '<input type="number" id="typeform-int" name="TypeForm[int]" value="0" min="4">',
            Number::widget()->config($this->model, 'int')->min(4)->render(),
        );
    }

    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="number" id="typeform-int" name="TypeForm[int]" value="0" placeholder="PlaceHolder Text">',
            Number::widget()->config($this->model, 'int')->placeholder('PlaceHolder Text')->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="number" id="typeform-int" name="TypeForm[int]" value="0">',
            Number::widget()->config($this->model, 'int')->render(),
        );
    }

    public function testValue(): void
    {
        // string value numeric `1`.
        $this->model->setAttribute('string', '1');
        $this->assertSame(
            '<input type="number" id="typeform-string" name="TypeForm[string]" value="1">',
            Number::widget()->config($this->model, 'string')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Number widget must be a numeric value.');
        Number::widget()->config($this->model, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
