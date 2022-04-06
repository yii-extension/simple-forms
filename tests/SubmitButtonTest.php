<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\SubmitButton;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Html;

final class SubmitButtonTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame('<input type="submit" id="w1-submit" name="w1-submit">', SubmitButton::create()->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
