<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Image;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Html;

final class ImageTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAlt(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image" name="w1-image" alt="Submit">',
            Image::create()->alt('Submit')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image" name="w1-image" autofocus>',
            Image::create()->autofocus()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image" name="w1-image" disabled>',
            Image::create()->disabled()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="id-test" name="w1-image">',
            Image::create()->id('id-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $image = Image::create();
        $this->assertNotSame($image, $image->alt(''));
        $this->assertNotSame($image, $image->height(''));
        $this->assertNotSame($image, $image->src(''));
        $this->assertNotSame($image, $image->width(''));
    }

    /**
     * @throws ReflectionException
     */
    public function testHeight(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image" name="w1-image" height="20">',
            Image::create()->height('20')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image" name="name-test">',
            Image::create()->name('name-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame('<input type="image" id="w1-image" name="w1-image">', Image::create()->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testSrc(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image" name="w1-image" src="img_submit.gif">',
            Image::create()->src('img_submit.gif')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabIndex(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertEqualsWithoutLE(
            '<input type="image" id="w1-image" name="w1-image" tabindex="1">',
            Image::create()->tabIndex(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWidth(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image" name="w1-image" width="20%">',
            Image::create()->width('20%')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" name="w1-image">',
            Image::create()->id(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image">',
            Image::create()->name(null)->render(),
        );
    }
}
