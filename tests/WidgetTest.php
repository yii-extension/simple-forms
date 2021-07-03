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
        $this->assertSame(
            '<personalform-name disabled>',
            StubWidget::widget()->attributes(['disabled' => true])->render(),
        );
    }

    public function testAutofocus(): void
    {
        $this->assertSame('<personalform-name autofocus>', StubWidget::widget()->autofocus()->render());
    }

    public function testCharset(): void
    {
        $this->assertSame(
            '<personalform-name name="PersonalForm[имя]">',
            StubWidget::widget()->config(new PersonalForm(), 'имя')->charset('UTF-8')->render()
        );
    }

    public function testDisabled(): void
    {
        $this->assertSame('<personalform-name disabled>', StubWidget::widget()->disabled()->render());
    }

    public function testForm(): void
    {
        $this->assertSame(
            '<personalform-name form="test-form-id">',
            StubWidget::widget()->form('test-form-id')->render(),
        );
    }

    public function testGetInputNameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The formName cannot be empty.');
        $this->invokeMethod(StubWidget::widget(), 'getInputName', ['', 'test']);
    }

    public function testGetId(): void
    {
        $this->assertSame('<personalform-name>', StubWidget::widget()->render());
    }

    public function testId(): void
    {
        $this->assertSame('<test-2>', StubWidget::widget()->id('test-2')->render());
    }

    public function testNoPlaceholder(): void
    {
        $this->assertSame('<personalform-name>', StubWidget::widget()->noPlaceHolder()->render());
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
            StubWidget::widget()->placeHolder('testCustomPlaceHolder')->render(),
        );
    }

    public function testRequired(): void
    {
        $this->assertSame('<personalform-name required>', StubWidget::widget()->required()->render());
    }

    public function testSpellCheck(): void
    {
        $this->assertSame('<personalform-name spellcheck>', StubWidget::widget()->spellcheck()->render());
    }

    public function testTabIndex(): void
    {
        $this->assertSame('<personalform-name tabindex="0">', StubWidget::widget()->tabIndex()->render());
    }

    public function testTitle(): void
    {
        $this->assertSame(
            '<personalform-name title="Enter the city, municipality, avenue, house or apartment number.">',
            StubWidget::widget()->title('Enter the city, municipality, avenue, house or apartment number.')->render()
        );
    }

    public function testValidateIntegerPositive(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value must be a positive integer.');
        $this->invokeMethod(StubWidget::widget(), 'validateIntegerPositive', [-1]);
    }
}
