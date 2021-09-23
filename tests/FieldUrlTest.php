<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class FieldUrlTest extends TestCase
{
    use TestTrait;

    private TypeForm $model;

    public function testMaxLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" value maxlength="10" placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->url(['maxlength' => 10])->render(),
        );
    }

    public function testMinLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" value minlength="4" placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->url(['minlength' => 4])->render(),
        );
    }

    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" value pattern="^(http(s)?:\/\/)+[\w\-\._~:\/?#[\]@!$&amp;&apos;\(\)\*\+,;=.]+$" placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'string')
            ->url(['pattern' => "^(http(s)?:\/\/)+[\w\-\._~:\/?#[\]@!\$&'\(\)\*\+,;=.]+$"])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testPlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" value placeholder="PlaceHolder Text">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->url(['placeholder' => 'PlaceHolder Text'])->render(),
        );
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" value placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->url()->render(),
        );
    }

    public function testSize(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" value size="20" placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->url(['size' => 20])->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Url widget must be a string.');
        Field::widget()->config($this->model, 'int')->url()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
