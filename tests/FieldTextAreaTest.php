<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class FieldTextAreaTest extends TestCase
{
    use TestTrait;

    private TypeForm $model;

    public function testDirname(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" placeholder="Typed your text string." dirname="test.dir"></textarea>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->textArea(['dirname' => 'test.dir'])->render(),
        );
    }

    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        Field::widget()->config($this->model, 'string')->textArea(['dirname' => ''])->render();
    }

    public function testForm(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" form="form-id" placeholder="Typed your text string."></textarea>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->textArea(['form' => 'form-id'])->render(),
        );
    }

    public function testMaxLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" maxLength="100" placeholder="Typed your text string."></textarea>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->textArea(['maxLength' => 100])->render(),
        );
    }

    public function testPlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text"></textarea>
        <div>Write your text string.</div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'string')
            ->textArea(['placeholder' => 'PlaceHolder Text'])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" placeholder="Typed your text string."></textarea>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->textArea()->render(),
        );
    }

    public function testTextAreaReadOnly(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" readonly placeholder="Typed your text string."></textarea>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->textArea(['readonly' => true])->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('TextArea widget must be a string.');
        Field::widget()->config($this->model, 'array')->textArea()->render();
    }

    public function testWrap(): void
    {
        /** hard value */
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" placeholder="Typed your text string." wrap="hard"></textarea>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->textArea(['wrap' => 'hard'])->render(),
        );

        /** soft value */
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <textarea id="typeform-string" name="TypeForm[string]" placeholder="Typed your text string." wrap="soft"></textarea>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->textArea(['wrap' => 'soft'])->render(),
        );
    }

    public function testWrapException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid wrap value. Valid values are: hard, soft.');
        Field::widget()->config($this->model, 'string')->textArea(['wrap' => 'exception']);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
