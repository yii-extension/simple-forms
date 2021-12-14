<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Label;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class LabelTest extends TestCase
{
    use TestTrait;

    public function testForId(): void
    {
        $this->assertSame('<label for="test-id"></label>', Label::widget()->forId('test-id')->render());
    }

    public function testImmutability(): void
    {
        $label = Label::widget();
        $this->assertNotSame($label, $label->forId(''));
        $this->assertNotSame($label, $label->label(''));
    }

    public function testLabel(): void
    {
        $this->assertSame('<label>Label:</label>', Label::widget()->label('Label:')->render());
    }

    public function testRender(): void
    {
        $this->assertSame('<label></label>', Label::widget()->render());
    }

    /**
     * @link https://github.com/yiisoft/form/issues/85
     */
    public function testWithoutEncode(): void
    {
        $this->assertSame(
            '<label>My&nbsp;Field</label>',
            Label::widget()->encode(false)->label('My&nbsp;Field')->render(),
        );
    }
}
