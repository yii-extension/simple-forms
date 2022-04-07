<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Component;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Exception\AttributeNotSetException;
use Yii\Extension\Form\Exception\FormModelNotSetException;
use Yii\Extension\Form\Component\Label;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class LabelTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testForId(): void
    {
        $this->assertSame(
            '<label class="test-class" for="id-test">String</label>',
            Label::create()
                ->for(new PropertyType(), 'string')
                ->forId('id-test')
                ->attributes(['class' => 'test-class'])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetAttributeException(): void
    {
        $this->expectException(AttributeNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because "attribute" is not set.');
        Label::create()->for(new PropertyType(), 'attribute')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testGetFormModelException(): void
    {
        $this->expectException(FormModelNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because form model is not set.');
        $this->invokeMethod(Label::create(), 'getFormModel');
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $label = Label::create();
        $this->assertNotSame($label, $label->encode(false));
        $this->assertNotSame($label, $label->for(new PropertyType(), 'string'));
        $this->assertNotSame($label, $label->forId(''));
        $this->assertNotSame($label, $label->label(''));
    }

    /**
     * @throws ReflectionException
     */
    public function testLabel(): void
    {
        $this->assertSame(
            '<label for="propertytype-string">Label:</label>',
            Label::create()->for(new PropertyType(), 'string')->label('Label:')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<label for="propertytype-string">String</label>',
            Label::create()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     *
     * @link https://github.com/yiisoft/form/issues/85
     */
    public function testWithoutEncode(): void
    {
        $this->assertSame(
            '<label for="propertytype-string">My&nbsp;Field</label>',
            Label::create()->for(new PropertyType(), 'string')->encode(false)->label('My&nbsp;Field')->render(),
        );
    }
}
