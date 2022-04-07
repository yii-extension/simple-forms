<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Attribute;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Attribute\WidgetAttributes;
use Yii\Extension\Form\Exception\AttributeNotSetException;
use Yii\Extension\Form\Exception\FormModelNotSetException;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class WidgetAttributeTest extends TestCase
{
    use TestTrait;

    public function testGetAttributeNotSetException(): void
    {
        $widgetAttributes = $this->createWidget();
        $this->expectException(AttributeNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because "attribute" is not set.');
        $widgetAttributes->for(new PropertyType(), 'attribute');
    }

    /**
     * @throws ReflectionException
     */
    public function testGetFormModelException(): void
    {
        $widgetAttributes = $this->createWidget();
        $this->expectException(FormModelNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because form model is not set.');
        $this->invokeMethod($widgetAttributes, 'getFormModel');
    }

    public function testImmutability(): void
    {
        $widgetAttributes = $this->createWidget();
        $this->assertNotSame($widgetAttributes, $widgetAttributes->for(new PropertyType(), 'string'));
        $this->assertNotSame($widgetAttributes, $widgetAttributes->charset(''));
    }

    private function createWidget(): WidgetAttributes
    {
        return new class () extends WidgetAttributes {
            protected function run(): string
            {
                return '';
            }
        };
    }
}
