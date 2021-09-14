<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\DateTime;

final class DateTimeTest extends TestCase
{
    private TypeForm $model;

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-string" name="TypeForm[string]" value>',
            DateTime::widget()->config($this->model, 'string')->render(),
        );
    }

    public function testValue(): void
    {
        // string '2021-09-18'
        $this->model->setAttribute('string', '2021-09-18T23:59:00');
        $this->assertSame(
            '<input type="datetime" id="typeform-string" name="TypeForm[string]" value="2021-09-18T23:59:00">',
            DateTime::widget()->config($this->model, 'string')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->model->setAttribute('array', []);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('DateTime widget requires a string value.');
        $html = DateTime::widget()->config($this->model, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
