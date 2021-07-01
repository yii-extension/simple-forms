<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Input;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class InputTest extends TestCase
{
    use TestTrait;

    public function testAttributes(): void
    {
        $formModel = new PersonalForm();

        $expected = <<<'HTML'
        <input type="text" id="personalform-name" class="customClass" name="PersonalForm[name]" value="" placeholder="Name" required>
        HTML;
        $html = Input::widget()->config($formModel, 'name', ['class' => 'customClass'])->render();
        $this->assertEquals($expected, $html);
    }

    public function testAutofocus(): void
    {
        $formModel = new PersonalForm();

        $expected = <<<'HTML'
        <input type="text" id="personalform-name" name="PersonalForm[name]" value="" autofocus placeholder="Name" required>
        HTML;
        $html = Input::widget()->config($formModel, 'name')->autofocus()->render();
        $this->assertEquals($expected, $html);
    }

    public function testDisabled(): void
    {
        $formModel = new PersonalForm();

        $expected = <<<'HTML'
        <input type="text" id="personalform-name" name="PersonalForm[name]" value="" disabled placeholder="Name" required>
        HTML;
        $html = Input::widget()->config($formModel, 'name')->disabled()->render();
        $this->assertEquals($expected, $html);
    }

    public function testOninvalid(): void
    {
        $formModel = new PersonalForm();

        $expected = <<<'HTML'
        <input type="text" id="personalform-name" name="PersonalForm[name]" value="" oninvalid="this.setCustomValidity(&apos;No puede estar en blanco&apos;)" required placeholder="Name">
        HTML;
        $html = Input::widget()->config($formModel, 'name')
            ->onInvalid('No puede estar en blanco')
            ->required()
            ->render();
        $this->assertEquals($expected, $html);
    }

    public function testRender(): void
    {
        $formModel = new PersonalForm();

        $expected = <<<'HTML'
        <input type="text" id="personalform-name" name="PersonalForm[name]" value="" placeholder="Name" required>
        HTML;
        $html = Input::widget()->config($formModel, 'name')->render();
        $this->assertEquals($expected, $html);
    }

    public function testRenderException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The widget must be configured with FormInterface::class and Attribute.',
        );

        $html = Input::widget()->render();
    }

    public function testType(): void
    {
        $formModel = new PersonalForm();

        $expected = <<<'HTML'
        <input type="week" id="personalform-name" name="PersonalForm[name]" value="" placeholder="Name" required>
        HTML;
        $html = Input::widget()->config($formModel, 'name')->type(INPUT::TYPE_WEEK)->render();
        $this->assertEquals($expected, $html);
    }

    public function testTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Invalid type. Valid values are: "button", "checkbox", "color", "date", "datetime-local", "email", ' .
            '"file", "hidden", "image", "month", "number", "password", "radio", "range", "reset", "search", ' .
            '"submit", "tel", "text", "time", "url", "week".'
        );

        Input::widget()->type('noExist')->render();
    }
}
