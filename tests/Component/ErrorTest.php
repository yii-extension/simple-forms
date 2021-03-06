<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Component;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Exception\AttributeNotSetException;
use Yii\Extension\Form\Exception\FormModelNotSetException;
use Yii\Extension\Form\Component\Error;
use Yii\Extension\Form\Tests\TestSupport\Form\CustomError;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class ErrorTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testGetAttributeException(): void
    {
        $formModel = new CustomError();
        $this->expectException(AttributeNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because "attribute" is not set.');
        Error::create()->for($formModel, 'attribute')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testGetFormModelException(): void
    {
        $this->expectException(FormModelNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because form model is not set.');
        $this->invokeMethod(Error::create(), 'getFormModel');
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $error = Error::create();
        $this->assertNotSame($error, $error->encode(false));
        $this->assertNotSame($error, $error->for(new CustomError(), 'login'));
        $this->assertNotSame($error, $error->message(''));
        $this->assertNotSame($error, $error->messageCallback([]));
        $this->assertNotSame($error, $error->tag('div'));
    }

    /**
     * @throws ReflectionException
     */
    public function testMessage(): void
    {
        $formModel = new CustomError();
        $formModel->validate();
        $this->assertSame(
            '<div>This is custom error message.</div>',
            Error::create()->for($formModel, 'login')->message('This is custom error message.')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMessageCallback(): void
    {
        $formModel = new CustomError();
        $formModel->validate();
        $this->assertSame(
            '<div>This is custom error message.</div>',
            Error::create()
                ->for($formModel, 'login')
                ->messageCallback([$formModel, 'customError'])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMessageCallbackWithNoEncode(): void
    {
        $formModel = new CustomError();
        $formModel->validate();
        $this->assertSame(
            '<div>(&#10006;) This is custom error message.</div>',
            Error::create()
                ->for($formModel, 'login')
                ->encode(false)
                ->messageCallback([$formModel, 'customErrorWithIcon'])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $formModel = new CustomError();
        $formModel->validate();
        $this->assertSame('<div>Value cannot be blank.</div>', Error::create()->for($formModel, 'login')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testTag(): void
    {
        $formModel = new CustomError();
        $formModel->validate();
        $this->assertSame(
            'Value cannot be blank.',
            Error::create()->for($formModel, 'login')->tag('')->render(),
        );
        $this->assertSame(
            '<span>Value cannot be blank.</span>',
            Error::create()->for($formModel, 'login')->tag('span')->render(),
        );
    }
}
