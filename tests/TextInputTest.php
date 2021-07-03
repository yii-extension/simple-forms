<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\TextInput;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class TextInputTest extends TestCase
{
    use TestTrait;

    public function testAutocomplete(): void
    {
        /** on value */
        $this->assertSame(
            '<input type="text" id="personalform-name" name="PersonalForm[name]" value="" autocomplete="on" placeholder="Name" required>',
            TextInput::widget()->config(new PersonalForm(), 'name')->autocomplete()->render(),
        );
        /** off value */
        $this->assertSame(
            '<input type="text" id="personalform-name" name="PersonalForm[name]" value="" autocomplete="off" placeholder="Name" required>',
            TextInput::widget()->config(new PersonalForm(), 'name')->autocomplete('off')->render(),
        );
    }

    public function testAutocompleteException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value must be `on`,` off`.');
        TextInput::widget()->config(new PersonalForm(), 'name')->autocomplete('exception')->render();
    }

    public function testAttributes(): void
    {
        $this->assertSame(
            '<input type="text" id="personalform-name" class="customClass" name="PersonalForm[name]" value="" placeholder="Name" required>',
            TextInput::widget()->config(new PersonalForm(), 'name', ['class' => 'customClass'])->render(),
        );
    }

    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="text" id="personalform-name" name="PersonalForm[name]" value="" autofocus placeholder="Name" required>',
            TextInput::widget()->config(new PersonalForm(), 'name')->autofocus()->render(),
        );
    }

    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="text" id="personalform-name" name="PersonalForm[name]" value="" disabled placeholder="Name" required>',
            TextInput::widget()->config(new PersonalForm(), 'name')->disabled()->render(),
        );
    }

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="text" id="personalform-name" name="PersonalForm[name]" value="" maxlength="50" placeholder="Name" required>',
            TextInput::widget()->config(new PersonalForm(), 'name')->maxlength(50)->render(),
        );
    }

    public function testOninvalid(): void
    {
        $this->assertSame(
            '<input type="text" id="personalform-name" name="PersonalForm[name]" value="" oninvalid="this.setCustomValidity(&apos;No puede estar en blanco&apos;)" required placeholder="Name">',
            TextInput::widget()->config(new PersonalForm(), 'name')->onInvalid('No puede estar en blanco')->required()->render(),

        );
    }

    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="text" id="personalform-name" name="PersonalForm[name]" value="" readonly placeholder="Name" required>',
            TextInput::widget()->config(new PersonalForm(), 'name')->readonly()->render(),
        );
    }

    public function testRender(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('name', 'samdark');

        $this->assertSame(
            '<input type="text" id="personalform-name" name="PersonalForm[name]" value="samdark" placeholder="Name" required>',
            TextInput::widget()->config($model, 'name')->render(),
        );
    }

    public function testRenderException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The widget must be configured with FormInterface::class and Attribute.',
        );
        TextInput::widget()->render();
    }

    public function testSize(): void
    {
        $this->assertSame(
            '<input type="text" id="personalform-name" name="PersonalForm[name]" value="" size="10" required placeholder="Name">',
            TextInput::widget()->config(new PersonalForm(), 'name')->size(10)->required()->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value must be a bool|float|int|string|Stringable|null.');
        $html = TextInput::widget()->config(new PersonalForm(), 'citys')->render();
    }
}
