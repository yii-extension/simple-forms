<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Time;

final class TimeTest extends TestCase
{
    private TypeForm $model;

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="time" id="typeform-string" name="TypeForm[string]" value>',
            Time::widget()->config($this->model, 'string')->render(),
        );
    }

    public function testValue(): void
    {
        // string '23:20:50.52'
        $this->model->setAttribute('string', '23:20:50.52');
        $this->assertSame(
            '<input type="time" id="typeform-string" name="TypeForm[string]" value="23:20:50.52">',
            Time::widget()->config($this->model, 'string')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->model->setAttribute('array', []);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Time widget requires a string value.');
        $html = Time::widget()->config($this->model, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
