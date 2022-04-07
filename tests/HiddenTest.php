<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Hidden;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class HiddenTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="hidden" name="PropertyType[string]">',
            Hidden::create()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value string `1`.
        $this->assertSame(
            '<input type="hidden" name="PropertyType[string]" value="1">',
            Hidden::create()->for(new PropertyType(), 'string')->value('1')->render(),
        );

        // Value integer 1.
        $this->assertSame(
            '<input type="hidden" name="PropertyType[int]" value="1">',
            Hidden::create()->for(new PropertyType(), 'int')->value(1)->render(),
        );

        // Value null.
        $this->assertSame(
            '<input type="hidden" name="PropertyType[string]">',
            Hidden::create()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Hidden widget requires a string, numeric or null value.');
        Hidden::create()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithForm(): void
    {
        $formModel = new PropertyType();

        // Value string `1`.
        $formModel->setValue('string', '1');
        $this->assertSame(
            '<input type="hidden" name="PropertyType[string]" value="1">',
            Hidden::create()->for($formModel, 'string')->render(),
        );

        // Value integer 1.
        $formModel->setValue('int', 1);
        $this->assertSame(
            '<input type="hidden" name="PropertyType[int]" value="1">',
            Hidden::create()->for($formModel, 'int')->render(),
        );

        // Value `null`.
        $formModel->setValue('string', null);
        $this->assertSame(
            '<input type="hidden" name="PropertyType[string]">',
            Hidden::create()->for($formModel, 'string')->render(),
        );
    }
}
