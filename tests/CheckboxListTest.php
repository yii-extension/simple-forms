<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\CheckboxList;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;

final class CheckboxListTest extends TestCase
{
    use TestTrait;

    /** @var string[] */
    private array $sex = [1 => 'Female', 2 => 'Male'];

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div id="propertytype-array" autofocus>
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()->autofocus()->for(new PropertyType(), 'array')->items($this->sex)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1" disabled> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2" disabled> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()->disabled()->for(new PropertyType(), 'array')->items($this->sex)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerAttributes(): void
    {
        $expected = <<<HTML
        <div id="propertytype-array" class="test-class">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()
                ->for(new PropertyType(), 'array')
                ->containerAttributes(['class' => 'test-class'])
                ->items($this->sex)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerTag(): void
    {
        $expected = <<<HTML
        <span id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </span>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()
                ->for(new PropertyType(), 'array')
                ->containerTag('span')
                ->items($this->sex)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerTagWithNull(): void
    {
        $expected = <<<HTML
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()
                ->for(new PropertyType(), 'array')
                ->containerTag(null)
                ->items($this->sex)
                ->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div id="id-test">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()->for(new PropertyType(), 'array')->id('id-test')->items($this->sex)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testIndividualItemsAttributes(): void
    {
        // Set disabled `[1 => ['disabled' => 'true']]`, `[2 => ['class' => 'test-class']]`.
        $expected = <<<HTML
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1" disabled> Female</label>
        <label><input type="checkbox" class="test-class" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()
                ->for(new PropertyType(), 'array')
                ->individualItemsAttributes([1 => ['disabled' => true], 2 => ['class' => 'test-class']])
                ->items($this->sex)
                ->render(),
        );

        // Set required `[1 => ['required' => 'true']]`, and `[2 => ['disabled' => 'true']]`.
        $expected = <<<HTML
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1" required> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2" disabled> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()
                ->for(new PropertyType(), 'array')
                ->items($this->sex)
                ->individualItemsAttributes([1 => ['required' => true], 2 => ['disabled' => true]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testItemsAttributes(): void
    {
        $expected = <<<HTML
        <div id="propertytype-array">
        <label><input type="checkbox" class="test-class" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" class="test-class" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        HTML;
        $html = CheckboxList::create()
            ->for(new PropertyType(), 'array')
            ->items($this->sex)
            ->itemsAttributes(['class' => 'test-class'])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testItemFormater(): void
    {
        $expected = <<<HTML
        <div id="propertytype-array">
        <label><input type='checkbox' name='PropertyType[array][]' value='1'> Female</label>
        <label><input type='checkbox' name='PropertyType[array][]' value='2'> Male</label>
        </div>
        HTML;
        $html = CheckboxList::create()
            ->for(new PropertyType(), 'array')
            ->itemsFormatter(
                static function (CheckboxItem $item) {
                    return $item->checked
                        ? "<label><input type='checkbox' name='$item->name' value='$item->value' checked> $item->label</label>"
                        : "<label><input type='checkbox' name='$item->name' value='$item->value'> $item->label</label>";
                }
            )
            ->items($this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $checkboxList = CheckboxList::create();
        $this->assertNotSame($checkboxList, $checkboxList->autofocus());
        $this->assertNotSame($checkboxList, $checkboxList->containerAttributes([]));
        $this->assertNotSame($checkboxList, $checkboxList->containerTag());
        $this->assertNotSame($checkboxList, $checkboxList->id(null));
        $this->assertNotSame($checkboxList, $checkboxList->individualItemsAttributes());
        $this->assertNotSame($checkboxList, $checkboxList->items());
        $this->assertNotSame($checkboxList, $checkboxList->itemsAttributes());
        $this->assertNotSame($checkboxList, $checkboxList->itemsFormatter(null));
        $this->assertNotSame($checkboxList, $checkboxList->itemsFromValues());
        $this->assertNotSame($checkboxList, $checkboxList->separator(''));
        $this->assertNotSame($checkboxList, $checkboxList->tabindex(1));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testItemsFromValues(): void
    {
        $formModel = new PropertyType();

        // Value string `Male`.
        $formModel->setValue('array', ['Male']);

        $expected = <<<HTML
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="Female"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="Male" checked> Male</label>
        </div>
        HTML;
        $html = CheckboxList::create()
            ->for($formModel, 'array')
            ->itemsFromValues($this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div id="propertytype-array">
        <label><input type="checkbox" name="name-test[]" value="1"> Female</label>
        <label><input type="checkbox" name="name-test[]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()->for(new PropertyType(), 'array')->name('name-test')->items($this->sex)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()->for(new PropertyType(), 'array')->items($this->sex)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSeparator(): void
    {
        $expected = <<<HTML
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()->for(new PropertyType(), 'array')->items($this->sex)->separator(PHP_EOL)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabindex(): void
    {
        $expected = <<<HTML
        <div id="propertytype-array" tabindex="1">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()->for(new PropertyType(), 'array')->items($this->sex)->tabindex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value iterable `[2]`.
        $expected = <<<HTML
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2" checked> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()->for(new PropertyType(), 'array')->items($this->sex)->value([2])->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()->for(new PropertyType(), 'array')->items($this->sex)->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $formModel = new PropertyType();

        // Value int `1`.
        $formModel->setValue('int', 1);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('CheckboxList widget must be a array or null value.');
        CheckboxList::create()->for($formModel, 'int')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithForm(): void
    {
        $formModel = new PropertyType();

        // Value iterable `[2]`.
        $formModel->setValue('array', [2]);
        $expected = <<<HTML
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2" checked> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()->for($formModel, 'array')->items($this->sex)->render(),
        );

        // Value `null`.
        $formModel->setValue('array', null);
        $expected = <<<HTML
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()->for($formModel, 'array')->items($this->sex)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()->for(new PropertyType(), 'array')->id(null)->items($this->sex)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div id="propertytype-array">
        <label><input type="checkbox" name="PropertyType[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="PropertyType[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::create()->for(new PropertyType(), 'array')->items($this->sex)->name(null)->render(),
        );
    }
}
