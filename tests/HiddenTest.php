<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Hidden;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;

final class HiddenTest extends TestCase
{
    private TypeForm $model;

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="hidden" name="typeform-string" value>',
            Hidden::widget()->config($this->model, 'string')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Hidden widget requires a string value.');
        $html = Hidden::widget()->config($this->model, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
