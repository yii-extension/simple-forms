<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Hint;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class HintTest extends TestCase
{
    use TestTrait;

    public function testHint(): void
    {
        $this->assertSame('<div>Write your text.</div>', Hint::widget()->hint('Write your text.')->render());
    }

    public function testImmutability(): void
    {
        $hint = Hint::widget();
        $this->assertNotSame($hint, $hint->hint(null));
        $this->assertNotSame($hint, $hint->tag(''));
    }

    public function testRender(): void
    {
        $this->assertSame('<div></div>', Hint::widget()->render());
    }

    public function testTag(): void
    {
        $this->assertSame(
            '<span>Write your text.</span>',
            Hint::widget()->hint('Write your text.')->tag('span')->render(),
        );
    }

    public function testTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        Hint::widget()->tag('')->render();
    }
}
