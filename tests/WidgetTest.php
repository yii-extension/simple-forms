<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\Stub\StubWidget;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class WidgetTest extends TestCase
{
    use TestTrait;

    public function testAttributes(): void
    {
        $html = StubWidget::widget()->attributes(['disabled' => true])->render();
        $this->assertSame('<personalform-name disabled>', $html);
    }

    public function testAutofocus(): void
    {
        $html = StubWidget::widget()->autofocus()->render();
        $this->assertSame('<personalform-name autofocus>', $html);
    }

    public function testCharset(): void
    {
        $model = new PersonalForm();

        $html = StubWidget::widget()->config($model, 'имя')->charset('UTF-8')->render();
        $this->assertEqualsWithoutLE('<personalform-name name="PersonalForm[имя]">', $html);
    }

    public function testDisabled(): void
    {
        $html = StubWidget::widget()->disabled()->render();
        $this->assertEqualsWithoutLE('<personalform-name disabled>', $html);
    }

    public function testGetInputNameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The formName cannot be empty.');
        $this->invokeMethod(StubWidget::widget(), 'getInputName', ['', 'test']);
    }

    public function testGetId(): void
    {
        $model = new PersonalForm();

        $id = StubWidget::widget()->render();
        $this->assertSame('<personalform-name>', $id);
    }

    public function testId(): void
    {
        $id = StubWidget::widget()->id('test-2')->render();
        $this->assertSame('<test-2>', $id);
    }

    public function testParseAttribute(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute name must contain word characters only.');
        $this->invokeMethod(StubWidget::widget(), 'parseAttribute', ['']);
    }

    public function testRequired(): void
    {
        $html = StubWidget::widget()->required()->render();
        $this->assertEqualsWithoutLE('<personalform-name required>', $html);
    }
}
