<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Error;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\ValidatorForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class ErrorTest extends TestCase
{
    use TestTrait;

    public function testImmutability(): void
    {
        $error = Error::widget();
        $this->assertNotSame($error, $error->message(''));
        $this->assertNotSame($error, $error->tag('div'));
    }

    public function testMessage(): void
    {
        $this->assertSame(
            '<div>This is custom error message.</div>',
            Error::widget()->message('This is custom error message.')->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertEmpty(Error::widget()->render());
    }

    public function testTag(): void
    {
        $this->assertEmpty('', Error::widget()->tag('')->render());
        $this->assertSame(
            '<span>This is custom error message.</span>',
            Error::widget()->message('This is custom error message.')->tag('span')->render(),
        );
    }
}
