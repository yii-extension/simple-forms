<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Attribute;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Attribute\WidgetAttributes;
use Yii\Extension\Form\Exception\AttributeNotSetException;
use Yii\Extension\Form\Exception\FormModelNotSetException;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class WidgetAttributeTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetAttributeNotSetException(): void
    {
        $widgetAttributes = $this->createWidget();
        $this->expectException(AttributeNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because "attribute" is not set.');
        $widgetAttributes->for(new PropertyType(), 'attribute');
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetFormModelException(): void
    {
        $widgetAttributes = $this->createWidget();
        $this->expectException(FormModelNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because form model is not set.');
        $this->invokeMethod($widgetAttributes, 'getFormModel');
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
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
