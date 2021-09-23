<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Image;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Html;

final class ImageTest extends TestCase
{
    use TestTrait;

    private TypeForm $model;

    public function testAlt(): void
    {
        $this->assertSame(
            '<input type="image" id="image-1" name="image-1" alt="Submit">',
            Image::widget()->alt('Submit')->render(),
        );
    }

    public function testHeight(): void
    {
        $this->assertSame(
            '<input type="image" id="image-1" name="image-1" height="20">',
            Image::widget()->height('20')->render(),
        );
    }

    public function testImmutability(): void
    {
        $image = Image::widget();
        $this->assertNotSame($image, $image->alt(''));
        $this->assertNotSame($image, $image->height(''));
        $this->assertNotSame($image, $image->src(''));
        $this->assertNotSame($image, $image->width(''));
    }

    public function testSrc(): void
    {
        $this->assertSame(
            '<input type="image" id="image-1" name="image-1" src="img_submit.gif">',
            Image::widget()->src('img_submit.gif')->render(),
        );
    }

    public function testWidth(): void
    {
        $this->assertSame(
            '<input type="image" id="image-1" name="image-1" width="20%">',
            Image::widget()->width('20%')->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame('<input type="image" id="image-1" name="image-1">', Image::widget()->render());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
    }
}
