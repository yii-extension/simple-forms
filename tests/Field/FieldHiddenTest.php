<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class FieldHiddenTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="ActiveField[form_action]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->name('ActiveField[form_action]')->hidden(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->hidden(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="PropertyType[string]" value="1">
        </div>
        HTML;
        // Value string `1`.
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->hidden(new PropertyType(), 'string')->value('1')->render(),
        );

        $expected = <<<HTML
        <div>
        <input type="hidden" name="PropertyType[int]" value="1">
        </div>
        HTML;
        // Value integer 1.
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->hidden(new PropertyType(), 'int')->value(1)->render(),
        );

        $expected = <<<HTML
        <div>
        <input type="hidden" name="PropertyType[string]">
        </div>
        HTML;
        // Value null.
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->hidden(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Hidden widget requires a string, numeric or null value.');
        Field::create()->hidden(new PropertyType(), 'array')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `1`.
        $formModel->setValue('string', '1');
        $expected = <<<HTML
        <div>
        <input type="hidden" name="PropertyType[string]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->hidden($formModel, 'string')->render(),
        );

        // Value integer 1.
        $formModel->setValue('int', 1);
        $expected = <<<HTML
        <div>
        <input type="hidden" name="PropertyType[int]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->hidden($formModel, 'int')->render(),
        );

        // Value `null`.
        $formModel->setValue('string', null);
        $expected = <<<HTML
        <div>
        <input type="hidden" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->hidden($formModel, 'string')->render(),
        );
    }
}
