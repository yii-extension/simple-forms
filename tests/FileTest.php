<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\File;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;

final class FileTest extends TestCase
{
    private TypeForm $model;

    public function testAccept(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-tonull" name="TypeForm[toNull]" accept="image/*">',
            File::widget()->config($this->model, 'toNull')->accept('image/*')->render(),
        );
    }

    public function testForceUncheckedValue(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" name="TypeForm[toNull]" value><input type="file" id="typeform-tonull" name="TypeForm[toNull]">
        HTML;
        $html = File::widget()
            ->config($this->model, 'toNull', ['forceUncheckedValue' => ''])
            ->render();
        $this->assertSame($expected, $html);
    }

    public function testHiddenAttributes(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" id="test-id" name="TypeForm[toNull]" value><input type="file" id="typeform-tonull" name="TypeForm[toNull]">
        HTML;
        $html = File::widget()
            ->config(
                $this->model,
                'toNull',
                [
                    'forceUncheckedValue' => '',
                    'hiddenAttributes' => ['id' => 'test-id'],
                ]
            )
            ->render();
        $this->assertSame($expected, $html);
    }

    public function testImmutability(): void
    {
        $fileInput = File::widget();
        $this->assertNotSame($fileInput, $fileInput->accept(''));
        $this->assertNotSame($fileInput, $fileInput->form(''));
        $this->assertNotSame($fileInput, $fileInput->multiple());
    }

    public function testMultiple(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-tonull" name="TypeForm[toNull]" multiple>',
            File::widget()->config($this->model, 'toNull')->multiple()->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-tonull" name="TypeForm[toNull]">',
            File::widget()->config($this->model, 'toNull')->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
