<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field\Hint;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class HintTest extends TestCase
{
    use TestTrait;

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testHint(): void
    {
        $this->assertSame('<div>Write your text.</div>', Hint::widget()->hint('Write your text.')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testImmutability(): void
    {
        $hint = Hint::widget();
        $this->assertNotSame($hint, $hint->hint(null));
        $this->assertNotSame($hint, $hint->tag(''));
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRender(): void
    {
        $this->assertSame('<div></div>', Hint::widget()->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testTag(): void
    {
        $this->assertSame(
            '<span>Write your text.</span>',
            Hint::widget()->hint('Write your text.')->tag('span')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        Hint::widget()->tag('')->render();
    }
}
