<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\TextArea;

final class TextAreaTest extends TestCase
{
    private TypeForm $model;

    public function testCols(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" cols="50"></textarea>',
            TextArea::widget()->config($this->model, 'string')->cols(50)->render(),
        );
    }

    public function testDirname(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" dirname="test.dir"></textarea>',
            TextArea::widget()->config($this->model, 'string')->dirname('test.dir')->render(),
        );
    }

    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        TextArea::widget()->config($this->model, 'string')->dirname('')->render();
    }

    public function testForm(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" form="form-id"></textarea>',
            TextArea::widget()->config($this->model, 'string')->form('form-id')->render(),
        );
    }

    public function testImmutability(): void
    {
        $textArea = TextArea::widget();
        $this->assertNotSame($textArea, $textArea->cols(0));
        $this->assertNotSame($textArea, $textArea->dirname('test.dir'));
        $this->assertNotSame($textArea, $textArea->form(''));
        $this->assertNotSame($textArea, $textArea->maxlength(0));
        $this->assertNotSame($textArea, $textArea->placeholder(''));
        $this->assertNotSame($textArea, $textArea->readOnly());
        $this->assertNotSame($textArea, $textArea->rows(0));
        $this->assertNotSame($textArea, $textArea->wrap('hard'));
    }

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" maxlength="100"></textarea>',
            TextArea::widget()->config($this->model, 'string')->maxLength(100)->render(),
        );
    }

    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text"></textarea>',
            TextArea::widget()->config($this->model, 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]"></textarea>',
            TextArea::widget()->config($this->model, 'string')->render(),
        );
    }

    public function testTextAreaReadOnly(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" readonly></textarea>',
            TextArea::widget()->config($this->model, 'string')->readOnly()->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('TextArea widget must be a string.');
        $html = TextArea::widget()->config($this->model, 'array')->render();
    }

    public function testWrap(): void
    {
        /** hard value */
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" wrap="hard"></textarea>',
            TextArea::widget()->config($this->model, 'string')->wrap()->render(),
        );

        /** soft value */
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" wrap="soft"></textarea>',
            TextArea::widget()->config($this->model, 'string')->wrap('soft')->render(),
        );
    }

    public function testWrapException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid wrap value. Valid values are: hard, soft.');
        TextArea::widget()->config($this->model, 'string')->wrap('exception');
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
