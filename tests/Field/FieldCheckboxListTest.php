<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use StdClass;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;

final class FieldCheckboxListTest extends TestCase
{
    use TestTrait;

    /** @var string[]  */
    private array $sex = [1 => 'Female', 2 => 'Male'];

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array" autofocus>
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->autofocus()
                ->checkboxList(new PropertyType(), 'array', ['items()' => [$this->sex]])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testContainerAttributes(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array" class="test-class">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->checkboxList(
                    new PropertyType(),
                    'array',
                    ['containerAttributes()' => [['class' => 'test-class']], 'items()' => [$this->sex]],
                )
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testContainerTag(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <span id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->checkboxList(new PropertyType(), 'array', ['containerTag()' => ['span'], 'items()' => [$this->sex]])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testContainerTagWithNull(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->checkboxList(new PropertyType(), 'array', ['containerTag()' => [null], 'items()' => [$this->sex]])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1" disabled> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2" disabled> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->checkboxList(new PropertyType(), 'array', ['items()' => [$this->sex]])
                ->disabled()
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="id-test">Array</label>
        <div id="id-test">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->checkboxList(new PropertyType(), 'array', ['items()' => [$this->sex]])
                ->id('id-test')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testIndividualItemsAttributes(): void
    {
        // Set disabled `[1 => ['disabled' => 'true']]`, `[2 => ['class' => 'test-class']]`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1" disabled> Female</label>
        <label><input type="checkbox" class="test-class" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->checkboxList(
                    new PropertyType(),
                    'array',
                    [
                        'individualItemsAttributes()' => [[1 => ['disabled' => true], 2 => ['class' => 'test-class']]],
                        'items()' => [$this->sex],
                    ],
                )
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItemsAttributes(): void
    {
        // Set `['class' => 'test-class']]`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array">
        <label><input type="checkbox" class="test-class" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" class="test-class" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->checkboxList(
                    new PropertyType(),
                    'array',
                    ['items()' => [$this->sex], 'itemsAttributes()' => [['class' => 'test-class']]]
                )
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItemFormater(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array">
        <label><input type='checkbox' name='PropertyType[array][]' value='1'> Female</label>
        <label><input type='checkbox' name='PropertyType[array][]' value='2'> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->checkboxList(
                    new PropertyType(),
                    'array',
                    [
                        'items()' => [$this->sex],
                        'itemsFormatter()' => [
                            static function (CheckboxItem $item) {
                                return $item->checked
                                    ? "<label><input type='checkbox' name='$item->name' value='$item->value' checked> $item->label</label>"
                                    : "<label><input type='checkbox' name='$item->name' value='$item->value'> $item->label</label>";
                            },
                        ],
                    ],
                )
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItemsFromValues(): void
    {
        $formModel = new PropertyType();

        // Value string `Male`.
        $formModel->setValue('array', ['Male']);

        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array">
        <label><input type="checkbox" class="test-class" name="PropertyType[array][]" value="Female"> Female</label>
        <label><input type="checkbox" class="test-class" name="PropertyType[array][]" value="Male" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->checkboxList(
                    $formModel,
                    'array',
                    ['itemsFromValues()' => [$this->sex], 'itemsAttributes()' => [['class' => 'test-class']]]
                )
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array">
        <label><input type="checkbox" name="name-test[]" value="1"> Female</label>
        <label><input type="checkbox" name="name-test[]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->checkboxList(new PropertyType(), 'array', ['items()' => [$this->sex]])
                ->name('name-test')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->checkboxList(new PropertyType(), 'array', ['items()' => [$this->sex]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testSeparator(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>&#9866;<label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->checkboxList(new PropertyType(), 'array', ['items()' => [$this->sex], 'separator()' => ['&#9866;']])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabIndex(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array" tabindex="1">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->checkboxList(new PropertyType(), 'array', ['items()' => [$this->sex]])->tabindex(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value iterable `[2]`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->checkboxList(new PropertyType(), 'array', ['items()' => [$this->sex]])->value([2])->render(),
        );

        // Value `null`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->checkboxList(new PropertyType(), 'array', ['items()' => [$this->sex]])->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $formModel = new PropertyType();

        // Value object `stdClass`.
        $formModel->setValue('object', new StdClass());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('CheckboxList widget must be a array or null value.');
        Field::create()->checkboxList($formModel, 'object')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value iterable `[2]`.
        $formModel->setValue('array', [2]);

        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->checkboxList($formModel, 'array', ['items()' => [$this->sex]])->render(),
        );

        // Value `null`.
        $formModel->setValue('array', null);

        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->checkboxList($formModel, 'array', ['items()' => [$this->sex]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $expected = <<<'HTML'
        <div>
        <label>Array</label>
        <div>
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->checkboxList(new PropertyType(), 'array', ['items()' => [$this->sex]])->id(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-array">Array</label>
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->checkboxList(new PropertyType(), 'array', ['items()' => [$this->sex]])->name(null)->render(),
        );
    }
}
