<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Label;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;

final class LabelTest extends TestCase
{
    private TypeForm $model;

    /**
     * @link https://github.com/yiisoft/form/issues/85
     */
    public function testEncodeFalse(): void
    {
        $this->assertSame(
            '<label for="typeform-string">My&nbsp;Field</label>',
            Label::widget()->config($this->model, 'string', ['encode' => false])->label('My&nbsp;Field')->render(),
        );
    }

    public function testFor(): void
    {
        $this->assertSame(
            '<label for="for-id">String</label>',
            Label::widget()->config($this->model, 'string')->for('for-id')->render(),
        );
    }

    public function testImmutability(): void
    {
        $label = Label::widget();
        $this->assertNotSame($label, $label->for(''));
        $this->assertNotSame($label, $label->label(''));
    }

    public function testLabel(): void
    {
        $this->assertSame(
            '<label for="typeform-string">Label:</label>',
            Label::widget()->config($this->model, 'string')->label('Label:')->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<label for="typeform-string">String</label>',
            Label::widget()->config($this->model, 'string')->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
