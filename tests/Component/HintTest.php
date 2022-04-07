<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Component;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Exception\AttributeNotSetException;
use Yii\Extension\Form\Exception\FormModelNotSetException;
use Yii\Extension\Form\Component\Hint;
use Yii\Extension\Form\Tests\TestSupport\Form\HintPart;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class HintTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testEncodeWithFalse(): void
    {
        $this->assertSame(
            '<div>Write&nbsp;your&nbsp;text.</div>',
            Hint::create()
                ->for(new HintPart(), 'hint')
                ->encode(false)
                ->hint('Write&nbsp;your&nbsp;text.')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetAttributeException(): void
    {
        $this->expectException(AttributeNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because "attribute" is not set.');
        Hint::create()->for(new HintPart(), 'attribute')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testGetFormModelException(): void
    {
        $this->expectException(FormModelNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because form model is not set.');
        $this->invokeMethod(Hint::create(), 'getFormModel');
    }

    /**
     * @throws ReflectionException
     */
    public function testHint(): void
    {
        $this->assertSame(
            '<div>Write your text.</div>',
            Hint::create()->for(new HintPart(), 'hint')->hint('Write your text.')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<div id="id-test" class="test-class">Please enter your hint.</div>',
            Hint::create()
                ->for(new HintPart(), 'hint')
                ->id('id-test')
                ->attributes(['class' => 'test-class'])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $hint = Hint::create();
        $this->assertNotSame($hint, $hint->encode(false));
        $this->assertNotSame($hint, $hint->for(new HintPart(), 'hint'));
        $this->assertNotSame($hint, $hint->hint(null));
        $this->assertNotSame($hint, $hint->id(''));
        $this->assertNotSame($hint, $hint->tag(''));
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->assertSame('<div>Please enter your hint.</div>', Hint::create()->for(new HintPart(), 'hint')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testTag(): void
    {
        $this->assertSame(
            '<span>Please enter your hint.</span>',
            Hint::create()->for(new HintPart(), 'hint')->tag('span')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        Hint::create()->for(new HintPart(), 'hint')->tag('')->render();
    }
}
