<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\SubmitButton;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Html;

final class SubmitButtonTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="submit" id="w1-submit" name="w1-submit" autofocus>',
            SubmitButton::create()->autofocus()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="submit" id="w1-submit" name="w1-submit" disabled>',
            SubmitButton::create()->disabled()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testForm(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="submit" id="w1-submit" name="w1-submit" form="form-register">',
            SubmitButton::create()->form('form-register')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="submit" id="test-id" name="w1-submit">',
            SubmitButton::create()->id('test-id')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="submit" id="w1-submit" name="test-name">',
            SubmitButton::create()->name('test-name')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame('<input type="submit" id="w1-submit" name="w1-submit">', SubmitButton::create()->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testTabindex(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="submit" id="w1-submit" name="w1-submit" tabindex="1">',
            SubmitButton::create()->tabindex(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="submit" id="w1-submit" name="w1-submit" value="Save">',
            SubmitButton::create()->value('Save')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="submit" name="w1-submit">',
            SubmitButton::create()->id(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="submit" id="w1-submit">',
            SubmitButton::create()->name(null)->render(),
        );
    }
}
