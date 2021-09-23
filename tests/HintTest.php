<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Hint;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;

final class HintTest extends TestCase
{
    private TypeForm $model;

    public function testContent(): void
    {
        $this->assertSame(
            '<div>Write your text.</div>',
            Hint::widget()->config($this->model, 'string', ['hint' => 'Write your text.'])->render(),
        );
    }

    public function testEncodeFalse(): void
    {
        $html = Hint::widget()
            ->config($this->model, 'string', ['hint' => 'Write&nbsp;your&nbsp;text.', 'encode' => false])
            ->render();
        $this->assertSame('<div>Write&nbsp;your&nbsp;text.</div>', $html);
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<div>Write your text string.</div>',
            Hint::widget()->config($this->model, 'string')->render(),
        );
    }

    public function testTag(): void
    {
        $this->assertSame(
            '<span>Write your text string.</span>',
            Hint::widget()->config($this->model, 'string', ['tag' => 'span'])->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
