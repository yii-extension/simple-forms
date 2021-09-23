<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Html;

final class FieldImageTest extends TestCase
{
    use TestTrait;

    public function testAlt(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="image" id="image-1" name="image-1" alt="Submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->image(['alt' => 'Submit'])->render());
    }

    public function testHeight(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="image" id="image-1" name="image-1" height="20">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->image(['height' => '20'])->render());
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="image" id="image-1" name="image-1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->image()->render());
    }

    public function testSrc(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="image" id="image-1" name="image-1" src="img_submit.gif">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->image(['src' => 'img_submit.gif'])->render());
    }

    public function testWidth(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="image" id="image-1" name="image-1" width="20px">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->image(['width' => '20px'])->render());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
    }
}
