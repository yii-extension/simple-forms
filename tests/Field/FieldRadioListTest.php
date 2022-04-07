<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Widget\RadioList\RadioItem;

final class FieldRadioListTest extends TestCase
{
    use TestTrait;

    /** @var string[] */
    private array $sex = [1 => 'Female', 2 => 'Male'];

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int" autofocus>
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->autofocus()->radioList(new PropertyType(), 'int', ['items()' => [$this->sex]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testContainerAttributes(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int" class="test-class">
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->radioList(
                    new PropertyType(),
                    'int',
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
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <span id="propertytype-int">
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->radioList(new PropertyType(), 'int', ['containerTag()' => ['span'], 'items()' => [$this->sex]])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testContainerTagWithFalse(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->radioList(new PropertyType(), 'int', ['containerTag()' => [null], 'items()' => [$this->sex]])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int">
        <label><input type="radio" name="PropertyType[int]" value="1" disabled> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2" disabled> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->disabled()->radioList(new PropertyType(), 'int', ['items()' => [$this->sex]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">Int</label>
        <div id="id-test">
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->id('id-test')->radioList(new PropertyType(), 'int', ['items()' => [$this->sex]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testIndividualItemsAttributes(): void
    {
        // Set disabled `[1 => ['disabled' => 'true']]`, `[2 => ['class' => 'test-class']]`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int">
        <label><input type="radio" name="PropertyType[int]" value="1" disabled> Female</label>
        <label><input type="radio" class="test-class" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->radioList(
                    new PropertyType(),
                    'int',
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
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int">
        <label><input type="radio" class="test-class" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" class="test-class" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->radioList(
                    new PropertyType(),
                    'int',
                    ['items()' => [$this->sex], 'itemsAttributes()' => [['class' => 'test-class']]],
                )
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItemFormater(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int">
        <label><input type='checkbox' name='PropertyType[int]' value='1'> Female</label>
        <label><input type='checkbox' name='PropertyType[int]' value='2'> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->radioList(
                    new PropertyType(),
                    'int',
                    [
                        'items()' => [$this->sex],
                        'itemsFormatter()' => [
                            static function (RadioItem $item) {
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
        $formModel->setValue('string', 'Male');

        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <div id="propertytype-string">
        <label><input type="radio" name="PropertyType[string]" value="Female"> Female</label>
        <label><input type="radio" name="PropertyType[string]" value="Male" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList($formModel, 'string', ['itemsFromValues()' => [$this->sex]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int">
        <label><input type="radio" name="name-test" value="1"> Female</label>
        <label><input type="radio" name="name-test" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList(new PropertyType(), 'int', ['items()' => [$this->sex]])->name('name-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int">
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList(new PropertyType(), 'int', ['items()' => [$this->sex]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testSeparator(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int">
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->radioList(new PropertyType(), 'int', ['items()' => [$this->sex], 'separator()' => [PHP_EOL]])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int" tabindex="1">
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList(new PropertyType(), 'int', ['items()' => [$this->sex]])->tabindex(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="hidden" name="PropertyType[int]" value="0">
        <div id="propertytype-int">
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->radioList(new PropertyType(), 'int', ['items()' => [$this->sex], 'uncheckValue()' => ['0']])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value bool `false`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-bool">Bool</label>
        <div id="propertytype-bool">
        <label><input type="radio" name="PropertyType[bool]" value="0" checked> Female</label>
        <label><input type="radio" name="PropertyType[bool]" value="1"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->radioList(new PropertyType(), 'bool', ['items()' => [[0 => 'Female', 1 => 'Male']]])
                ->value(false)
                ->render(),
        );

        // Value bool `true`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-bool">Bool</label>
        <div id="propertytype-bool">
        <label><input type="radio" name="PropertyType[bool]" value="0"> Female</label>
        <label><input type="radio" name="PropertyType[bool]" value="1" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->radioList(new PropertyType(), 'bool', ['items()' => [[0 => 'Female', 1 => 'Male']]])
                ->value(true)
                ->render(),
        );

        // Value int `1`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int">
        <label><input type="radio" name="PropertyType[int]" value="1" checked> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList(new PropertyType(), 'int', ['items()' => [$this->sex]])->value(1)->render(),
        );

        // Value int `2`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int">
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList(new PropertyType(), 'int', ['items()' => [$this->sex]])->value(2)->render(),
        );

        // Value string '1'
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <div id="propertytype-string">
        <label><input type="radio" name="PropertyType[string]" value="1" checked> Female</label>
        <label><input type="radio" name="PropertyType[string]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList(new PropertyType(), 'string', ['items()' => [$this->sex]])->value('1')->render(),
        );

        // Value string '2'
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <div id="propertytype-string">
        <label><input type="radio" name="PropertyType[string]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[string]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList(new PropertyType(), 'string', ['items()' => [$this->sex]])->value('2')->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int">
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList(new PropertyType(), 'int', ['items()' => [$this->sex]])->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('RadioList widget value can not be an iterable or an object.');
        Field::create()->radioList(new PropertyType(), 'array')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithForm(): void
    {
        $formModel = new PropertyType();

        // Value bool `false`.
        $formModel->setValue('bool', false);
        $expected = <<<HTML
        <div>
        <label for="propertytype-bool">Bool</label>
        <div id="propertytype-bool">
        <label><input type="radio" name="PropertyType[bool]" value="0" checked> Female</label>
        <label><input type="radio" name="PropertyType[bool]" value="1"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->radioList($formModel, 'bool', ['items()' => [[0 => 'Female', 1 => 'Male']]])
                ->render(),
        );

        // Value bool `true`.
        $formModel->setValue('bool', true);
        $expected = <<<HTML
        <div>
        <label for="propertytype-bool">Bool</label>
        <div id="propertytype-bool">
        <label><input type="radio" name="PropertyType[bool]" value="0"> Female</label>
        <label><input type="radio" name="PropertyType[bool]" value="1" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->radioList($formModel, 'bool', ['items()' => [[0 => 'Female', 1 => 'Male']]])
                ->render(),
        );

        // Value int `1`.
        $formModel->setValue('int', 1);
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int">
        <label><input type="radio" name="PropertyType[int]" value="1" checked> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList($formModel, 'int', ['items()' => [$this->sex]])->render(),
        );

        // Value int `2`.
        $formModel->setValue('int', 2);
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int">
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList($formModel, 'int', ['items()' => [$this->sex]])->render(),
        );

        // Value string '1'
        $formModel->setValue('string', '1');
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <div id="propertytype-string">
        <label><input type="radio" name="PropertyType[string]" value="1" checked> Female</label>
        <label><input type="radio" name="PropertyType[string]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList($formModel, 'string', ['items()' => [$this->sex]])->render(),
        );

        // Value string '2'
        $formModel->setValue('string', '2');
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <div id="propertytype-string">
        <label><input type="radio" name="PropertyType[string]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[string]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList($formModel, 'string', ['items()' => [$this->sex]])->render(),
        );

        // Value `null`.
        $formModel->setValue('int', null);
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int">
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList($formModel, 'int', ['items()' => [$this->sex]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label>Int</label>
        <div>
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList(new PropertyType(), 'int', ['items()' => [$this->sex]])->id(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <div id="propertytype-int">
        <label><input type="radio" name="PropertyType[int]" value="1"> Female</label>
        <label><input type="radio" name="PropertyType[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->radioList(new PropertyType(), 'int', ['items()' => [$this->sex]])->name(null)->render(),
        );
    }
}
