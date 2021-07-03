<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;
use Yii\Extension\Simple\Forms\PasswordInput;

final class PasswordInputTest extends TestCase
{
    public function testAutocomplete(): void
    {
        /** on value */
        $this->assertSame(
            '<input type="password" id="personalform-name" name="PersonalForm[name]" value="" autocomplete="on" placeholder="Name" required>',
            PasswordInput::widget()->config(new PersonalForm(), 'name')->autocomplete()->render(),
        );
        /** off value */
        $this->assertSame(
            '<input type="password" id="personalform-name" name="PersonalForm[name]" value="" autocomplete="off" placeholder="Name" required>',
            PasswordInput::widget()->config(new PersonalForm(), 'name')->autocomplete('off')->render(),
        );
    }

    public function testAutocompleteException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value must be `on`,` off`.');
        PasswordInput::widget()->config(new PersonalForm(), 'name')->autocomplete('exception')->render();
    }

    public function testAttributes(): void
    {
        $this->assertSame(
            '<input type="password" id="personalform-name" class="customClass" name="PersonalForm[name]" value="" placeholder="Name" required>',
            PasswordInput::widget()->config(new PersonalForm(), 'name', ['class' => 'customClass'])->render(),
        );
    }

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="password" id="personalform-name" name="PersonalForm[name]" value="" maxlength="50" placeholder="Name" required>',
            PasswordInput::widget()->config(new PersonalForm(), 'name')->maxlength(50)->render(),
        );
    }

    public function testOninvalid(): void
    {
        $this->assertSame(
            '<input type="password" id="personalform-name" name="PersonalForm[name]" value="" oninvalid="this.setCustomValidity(&apos;No puede estar en blanco&apos;)" placeholder="Name" required>',
            PasswordInput::widget()->config(new PersonalForm(), 'name')->onInvalid('No puede estar en blanco')->render(),
        );
    }

    public function testPattern(): void
    {
        $this->assertSame(
            '<input type="password" id="personalform-name" name="PersonalForm[name]" value="" pattern="[A-Za-z]{10}" placeholder="Name" required>',
            PasswordInput::widget()->config(new PersonalForm(), 'name')->pattern('[A-Za-z]{10}')->render(),
        );
    }

    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="password" id="personalform-name" name="PersonalForm[name]" value="" readonly placeholder="Name" required>',
            PasswordInput::widget()->config(new PersonalForm(), 'name')->readonly()->render(),
        );
    }

    public function testRender(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('name', 'samdark');

        $this->assertSame(
            '<input type="password" id="personalform-name" name="PersonalForm[name]" value="samdark" placeholder="Name" required>',
            PasswordInput::widget()->config($model, 'name')->render(),
        );
    }

    public function testRenderException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The widget must be configured with FormInterface::class and Attribute.',
        );
        PasswordInput::widget()->render();
    }

    public function testSize(): void
    {
        $this->assertSame(
            '<input type="password" id="personalform-name" name="PersonalForm[name]" value="" size="10" required placeholder="Name">',
            PasswordInput::widget()->config(new PersonalForm(), 'name')->size(10)->required()->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value must be a bool|float|int|string|Stringable|null.');
        $html = PasswordInput::widget()->config(new PersonalForm(), 'citys')->render();
    }
}
