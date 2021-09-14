<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Attribute;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Widget\ModelAttributesWidget;

final class ModelAttributesTest extends TestCase
{
    use TestTrait;

    private TypeForm $model;

    public function testGetFormModelException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Form model is not set.');
        $this->invokeMethod(ModelAttributesWidget::widget(), 'getModel');
    }

    public function testImmutability(): void
    {
        $modelAttributes = ModelAttributesWidget::widget();
        $this->assertNotSame($modelAttributes, $modelAttributes->charset(''));
        $this->assertNotSame($modelAttributes, $modelAttributes->config($this->model, 'string', []));
        $this->assertNotSame($modelAttributes, $modelAttributes->id(''));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
