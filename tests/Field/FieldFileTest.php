<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class FieldFileTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAccept(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-array">Array</label>
        <input type="file" id="propertytype-array" name="PropertyType[array][]" accept="image/*">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->file(new PropertyType(), 'array', ['accept()' => ['image/*']])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-array">Array</label>
        <input type="file" id="propertytype-array" name="PropertyType[array][]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->autofocus()->file(new PropertyType(), 'array')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-array">Array</label>
        <input type="file" id="propertytype-array" name="PropertyType[array][]" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->disabled()->file(new PropertyType(), 'array')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-required">Required</label>
        <input type="file" id="validatorrules-required" name="ValidatorRules[required][]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->file(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testHiddenAttributes(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <input type="hidden" id="test-id" name="PropertyType[array]" value="0"><input type="file" id="propertytype-array" name="PropertyType[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->file(
                    new PropertyType(),
                    'array',
                    ['uncheckValue()' => ['0'], 'hiddenAttributes()' => [['id' => 'test-id']]]
                )
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">Array</label>
        <input type="file" id="id-test" name="PropertyType[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->file(new PropertyType(), 'array')->id('id-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMultiple(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-array">Array</label>
        <input type="file" id="propertytype-array" name="PropertyType[array][]" multiple>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->file(new PropertyType(), 'array', ['multiple()' => [true]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-array">Array</label>
        <input type="file" id="propertytype-array" name="name-test[]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->file(new PropertyType(), 'array')->name('name-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-array">Array</label>
        <input type="file" id="propertytype-array" name="PropertyType[array][]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->file(new PropertyType(), 'array')->required()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-array">Array</label>
        <input type="file" id="propertytype-array" name="PropertyType[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->file(new PropertyType(), 'array')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-array">Array</label>
        <input type="file" id="propertytype-array" name="PropertyType[array][]" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->file(new PropertyType(), 'array')->tabindex(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <input type="hidden" name="PropertyType[array]" value="0"><input type="file" id="propertytype-array" name="PropertyType[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->file(new PropertyType(), 'array', ['uncheckValue()' => ['0']])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label>Array</label>
        <input type="file" name="PropertyType[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->file(new PropertyType(), 'array')->id(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-array">Array</label>
        <input type="file" id="propertytype-array" name="PropertyType[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->file(new PropertyType(), 'array')->name(null)->render(),
        );
    }
}
