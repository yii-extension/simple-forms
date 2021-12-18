<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field\Label;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class LabelTest extends TestCase
{
    use TestTrait;

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testForId(): void
    {
        $this->assertSame('<label for="test-id"></label>', Label::widget()->forId('test-id')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testImmutability(): void
    {
        $label = Label::widget();
        $this->assertNotSame($label, $label->forId(''));
        $this->assertNotSame($label, $label->label(''));
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testLabel(): void
    {
        $this->assertSame('<label>Label:</label>', Label::widget()->label('Label:')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRender(): void
    {
        $this->assertSame('<label></label>', Label::widget()->render());
    }

    /**
     * @link https://github.com/yiisoft/form/issues/85
     */
    public function testWithoutEncode(): void
    {
        $this->assertSame(
            '<label>My&nbsp;Field</label>',
            Label::widget()->encode(false)->label('My&nbsp;Field')->render(),
        );
    }
}
