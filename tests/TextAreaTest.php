<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yii\Extension\Simple\Forms\TextArea;

final class TextAreaTest extends TestCase
{
    public function testCols(): void
    {
        $this->assertSame(
            '<textarea id="personalform-name" name="PersonalForm[name]" cols="10" placeholder="Name"></textarea>',
            TextArea::widget()->config(new PersonalForm(), 'name')->cols(10)->render(),
        );
    }

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<textarea id="personalform-name" name="PersonalForm[name]" maxlength="50" placeholder="Name"></textarea>',
            TextArea::widget()->config(new PersonalForm(), 'name')->maxlength(50)->render(),
        );
    }

    public function testRender(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('name', 'samdark');

        $this->assertSame(
            '<textarea id="personalform-name" name="PersonalForm[name]" placeholder="Name">samdark</textarea>',
            TextArea::widget()->config($model, 'name')->render(),
        );
    }

    public function testReadonly(): void
    {
        $this->assertSame(
            '<textarea id="personalform-name" name="PersonalForm[name]" readonly placeholder="Name"></textarea>',
            TextArea::widget()->config(new PersonalForm(), 'name')->readonly()->render(),
        );
    }

    public function testRows(): void
    {
        $this->assertSame(
            '<textarea id="personalform-name" name="PersonalForm[name]" rows="6" placeholder="Name"></textarea>',
            TextArea::widget()->config(new PersonalForm(), 'name')->rows(6)->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value must be a string|null.');
        $html = TextArea::widget()->config(new PersonalForm(), 'cityBirth')->render();
    }

    public function testWrap(): void
    {
        /** hard value */
        $this->assertSame(
            '<textarea id="personalform-name" name="PersonalForm[name]" wrap="hard" placeholder="Name"></textarea>',
            TextArea::widget()->config(new PersonalForm(), 'name')->wrap()->render(),
        );
        /** soft value */
        $this->assertSame(
            '<textarea id="personalform-name" name="PersonalForm[name]" wrap="soft" placeholder="Name"></textarea>',
            TextArea::widget()->config(new PersonalForm(), 'name')->wrap('soft')->render(),
        );
    }

    public function testWrapException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid wrap value. Valid values are: hard, soft.');
        TextArea::widget()->config(new PersonalForm(), 'name')->wrap('exception');
    }
}
