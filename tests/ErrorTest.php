<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Error;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class ErrorTest extends TestCase
{
    use TestTrait;

    private array $record = [];
    private PersonalForm $model;

    public function testImmutability(): void
    {
        $error = Error::widget();
        $this->assertNotSame($error, $error->message(''));
        $this->assertNotSame($error, $error->messageCallback([]));
        $this->assertNotSame($error, $error->tag());
    }

    public function testMessage(): void
    {
        $html = Error::widget()->config($this->model, 'name')->message('This is custom error message.')->render();
        $this->assertSame('<div>This is custom error message.</div>', $html);
    }

    public function testMessageCallback(): void
    {
        $html = Error::widget()
            ->config($this->model, 'name')
            ->messageCallback([$this->model, 'customError'])
            ->render();
        $this->assertSame('<div>This is custom error message.</div>', $html);
    }

    public function testMessageCallbackWithNoEncode(): void
    {
        $html = Error::widget()
            ->config($this->model, 'name', ['encode' => false])
            ->messageCallback([$this->model, 'customErrorWithIcon'])
            ->render();
        $this->assertSame('<div>(&#10006;) This is custom error message.</div>', $html);
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<div>Value cannot be blank.</div>',
            Error::widget()->config($this->model, 'name')->render(),
        );
    }

    public function testTag(): void
    {
        $this->assertSame(
            'Value cannot be blank.',
            Error::widget()->config($this->model, 'name')->tag()->render(),
        );
        $this->assertSame(
            '<span>Value cannot be blank.</span>',
            Error::widget()->config($this->model, 'name')->tag('span')->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new PersonalForm();
        $this->model->load(['PersonalForm' => ['name' => '']]);
        $validator = $this->createValidatorMock();
        $validator->validate($this->model);
    }
}
