<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\FieldPart;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Exception\AttributeNotSetException;
use Yii\Extension\Form\Exception\FormModelNotSetException;
use Yii\Extension\Form\FieldPart\Error;
use Yii\Extension\Form\Tests\TestSupport\Form\CustomError;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class ErrorTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetAttributeException(): void
    {
        $formModel = new CustomError();
        $this->expectException(AttributeNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because "attribute" is not set.');
        Error::widget()->for($formModel, 'attribute')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetFormModelException(): void
    {
        $formModel = new CustomError();
        $this->expectException(FormModelNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because form model is not set.');
        $this->invokeMethod(Error::widget(), 'getFormModel');
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $error = Error::widget();
        $this->assertNotSame($error, $error->attributes([]));
        $this->assertNotSame($error, $error->encode(false));
        $this->assertNotSame($error, $error->for(new CustomError(), 'login'));
        $this->assertNotSame($error, $error->message(''));
        $this->assertNotSame($error, $error->messageCallback([]));
        $this->assertNotSame($error, $error->tag('div'));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMessage(): void
    {
        $formModel = new CustomError();
        $formModel->validateWithAttributes();
        $this->assertSame(
            '<div>This is custom error message.</div>',
            Error::widget()->for($formModel, 'login')->message('This is custom error message.')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMessageCallback(): void
    {
        $formModel = new CustomError();
        $formModel->validateWithAttributes();
        $this->assertSame(
            '<div>This is custom error message.</div>',
            Error::widget()
                ->for($formModel, 'login')
                ->messageCallback([$formModel, 'customError'])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMessageCallbackWithNoEncode(): void
    {
        $formModel = new CustomError();
        $formModel->validateWithAttributes();
        $this->assertSame(
            '<div>(&#10006;) This is custom error message.</div>',
            Error::widget()
                ->for($formModel, 'login')
                ->encode(false)
                ->messageCallback([$formModel, 'customErrorWithIcon'])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $formModel = new CustomError();
        $formModel->validateWithAttributes();
        $this->assertSame('<div>Value cannot be blank.</div>', Error::widget()->for($formModel, 'login')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTag(): void
    {
        $formModel = new CustomError();
        $formModel->validateWithAttributes();
        $this->assertSame(
            'Value cannot be blank.',
            Error::widget()->for($formModel, 'login')->tag('')->render(),
        );
        $this->assertSame(
            '<span>Value cannot be blank.</span>',
            Error::widget()->for($formModel, 'login')->tag('span')->render(),
        );
    }
}
