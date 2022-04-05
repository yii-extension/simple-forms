<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Hidden;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class HiddenTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="hidden" name="PropertyType[string]">',
            Hidden::widget()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `1`.
        $this->assertSame(
            '<input type="hidden" name="PropertyType[string]" value="1">',
            Hidden::widget()->for(new PropertyType(), 'string')->value('1')->render(),
        );

        // Value integer 1.
        $this->assertSame(
            '<input type="hidden" name="PropertyType[int]" value="1">',
            Hidden::widget()->for(new PropertyType(), 'int')->value(1)->render(),
        );

        // Value null.
        $this->assertSame(
            '<input type="hidden" name="PropertyType[string]">',
            Hidden::widget()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Hidden widget requires a string, numeric or null value.');
        Hidden::widget()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithForm(): void
    {
        $formModel = new PropertyType();

        // Value string `1`.
        $formModel->setValue('string', '1');
        $this->assertSame(
            '<input type="hidden" name="PropertyType[string]" value="1">',
            Hidden::widget()->for($formModel, 'string')->render(),
        );

        // Value integer 1.
        $formModel->setValue('int', 1);
        $this->assertSame(
            '<input type="hidden" name="PropertyType[int]" value="1">',
            Hidden::widget()->for($formModel, 'int')->render(),
        );

        // Value `null`.
        $formModel->setValue('string', null);
        $this->assertSame(
            '<input type="hidden" name="PropertyType[string]">',
            Hidden::widget()->for($formModel, 'string')->render(),
        );
    }
}
