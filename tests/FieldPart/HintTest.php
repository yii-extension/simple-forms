<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\FieldPart;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Exception\AttributeNotSetException;
use Yii\Extension\Form\Exception\FormModelNotSetException;
use Yii\Extension\Form\FieldPart\Hint;
use Yii\Extension\Form\Tests\TestSupport\Form\HintPart;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class HintTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testEncodeWithFalse(): void
    {
        $this->assertSame(
            '<div>Write&nbsp;your&nbsp;text.</div>',
            Hint::widget()
                ->for(new HintPart(), 'hint')
                ->encode(false)
                ->hint('Write&nbsp;your&nbsp;text.')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetAttributeException(): void
    {
        $this->expectException(AttributeNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because "attribute" is not set.');
        Hint::widget()->for(new HintPart(), 'attribute')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetFormModelException(): void
    {
        $this->expectException(FormModelNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because form model is not set.');
        $this->invokeMethod(Hint::widget(), 'getFormModel');
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testHint(): void
    {
        $this->assertSame(
            '<div>Write your text.</div>',
            Hint::widget()->for(new HintPart(), 'hint')->hint('Write your text.')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<div id="id-test" class="test-class">Please enter your hint.</div>',
            Hint::widget()
                ->for(new HintPart(), 'hint')
                ->id('id-test')
                ->attributes(['class' => 'test-class'])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $hint = Hint::widget();
        $this->assertNotSame($hint, $hint->attributes([]));
        $this->assertNotSame($hint, $hint->encode(false));
        $this->assertNotSame($hint, $hint->for(new HintPart(), 'hint'));
        $this->assertNotSame($hint, $hint->hint(null));
        $this->assertNotSame($hint, $hint->id(''));
        $this->assertNotSame($hint, $hint->tag(''));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame('<div>Please enter your hint.</div>', Hint::widget()->for(new HintPart(), 'hint')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTag(): void
    {
        $this->assertSame(
            '<span>Please enter your hint.</span>',
            Hint::widget()->for(new HintPart(), 'hint')->tag('span')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        Hint::widget()->for(new HintPart(), 'hint')->tag('')->render();
    }
}
