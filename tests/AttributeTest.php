<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Widget\StubWidget;

final class AttributeTest extends TestCase
{
    use TestTrait;

    public function testAccesskey(): void
    {
        $this->assertSame(
            '<personalform-name accesskey="h">',
            StubWidget::widget()->config(new PersonalForm(), 'name')->accesskey("h")->render(),
        );
    }

    public function testCharset(): void
    {
        $this->assertSame(
            '<personalform-имя name="PersonalForm[имя]">',
            StubWidget::widget()->config(new PersonalForm(), 'имя')->charset('UTF-8')->name()->render(),
        );
    }

    public function testClass(): void
    {
        $this->assertSame(
            '<personalform-name class="test-class">',
            StubWidget::widget()->config(new PersonalForm(), 'name')->class('test-class')->render(),
        );
    }

    public function testDraggable(): void
    {
        $this->assertSame(
            '<personalform-name draggable="true">',
            StubWidget::widget()->config(new PersonalForm(), 'name')->draggable()->render(),
        );
    }

    public function testDir(): void
    {
        $this->assertSame(
            '<personalform-name dir="rtl">',
            StubWidget::widget()->config(new PersonalForm(), 'name')->dir('rtl')->render(),
        );
    }

    public function testDirException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The dir attribute value must be either "ltr", "rtl" or "auto".');
        StubWidget::widget()->config(new PersonalForm(), 'name')->dir('ntl')->render();
    }

    public function testId(): void
    {
        $this->assertSame(
            '<test-2>',
            StubWidget::widget()->config(new PersonalForm(), 'name')->id('test-2')->render(),
        );
    }

    public function testParseAttribute(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute name must contain word characters only.');
        $this->invokeMethod(StubWidget::widget(), 'parseAttribute', ['']);
    }

    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<personalform-name placeholder="testCustomPlaceHolder">',
            StubWidget::widget()->config(new PersonalForm(), 'name')->placeHolder('testCustomPlaceHolder')->render(),
        );
    }
}
