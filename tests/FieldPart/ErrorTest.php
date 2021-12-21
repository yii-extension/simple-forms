<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\FieldPart;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\FieldPart\Error;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class ErrorTest extends TestCase
{
    use TestTrait;

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testImmutability(): void
    {
        $error = Error::widget();
        $this->assertNotSame($error, $error->message(''));
        $this->assertNotSame($error, $error->tag('div'));
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMessage(): void
    {
        $this->assertSame(
            '<div>This is custom error message.</div>',
            Error::widget()->message('This is custom error message.')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRender(): void
    {
        $this->assertEmpty(Error::widget()->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testTag(): void
    {
        $this->assertEmpty('', Error::widget()->tag('')->render());
        $this->assertSame(
            '<span>This is custom error message.</span>',
            Error::widget()->message('This is custom error message.')->tag('span')->render(),
        );
    }
}
