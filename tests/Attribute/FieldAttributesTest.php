<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Attribute;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class FieldAttributesTest extends TestCase
{
    use TestTrait;

    private TypeForm $model;

    public function testAriaDescribedBy(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" value aria-describedby="typeform-string" placeholder="Typed your text string.">
        <div id="typeform-string">Write your text string.</div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'string')
            ->ariaDescribedBy()
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testContainerClass(): void
    {
        $expected = <<<'HTML'
        <div class="test-class">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" value placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'string')
            ->containerClass('test-class')
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testGetFormModelException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Model is not set.');
        $this->invokeMethod(Field::widget(), 'getModel');
    }

    public function testInputClass(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" class="test-class" name="TypeForm[string]" value placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'string')
            ->inputClass('test-class')
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testImmutability(): void
    {
        $field = Field::widget();
        $this->assertNotSame($field, $field->ariaDescribedBy());
        $this->assertNotSame($field, $field->config($this->model, 'string', []));
        $this->assertNotSame($field, $field->containerClass(''));
        $this->assertNotSame($field, $field->errorClass(''));
        $this->assertNotSame($field, $field->hintClass(''));
        $this->assertNotSame($field, $field->inputClass(''));
        $this->assertNotSame($field, $field->invalidClass(''));
        $this->assertNotSame($field, $field->labelClass(''));
        $this->assertNotSame($field, $field->template(''));
        $this->assertNotSame($field, $field->validClass(''));
    }

    public function testLabelClass(): void
    {
        $expected = <<<'HTML'
        <div>
        <label class="test-class" for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" value placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'string')
            ->labelClass('test-class')
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testTemplate(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="text" id="typeform-string" name="TypeForm[string]" value placeholder="Typed your text string.">
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'string')
            ->template('{input}')
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
