<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use StdClass;
use Yii\Extension\Form\Select;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Tag\Option;

final class SelectTest extends TestCase
{
    use TestTrait;

    private array $cities = [
        '1' => 'Moscu',
        '2' => 'San Petersburgo',
        '3' => 'Novosibirsk',
        '4' => 'Ekaterinburgo',
    ];
    private array $citiesGroups = [
        '1' => [
            '2' => ' Moscu',
            '3' => ' San Petersburgo',
            '4' => ' Novosibirsk',
            '5' => ' Ekaterinburgo',
        ],
        '2' => [
            '6' => 'Santiago',
            '7' => 'Concepcion',
            '8' => 'Chillan',
        ],
    ];
    private array $groups = [
        '1' => ['label' => 'Russia'],
        '2' => ['label' => 'Chile'],
    ];

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]" autofocus>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->autofocus()->for(new PropertyType(), 'int')->items($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]" disabled>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->disabled()->for(new PropertyType(), 'int')->items($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <select id="validatorrules-required" name="ValidatorRules[required]" required>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new ValidatorRules(), 'required')->items($this->cities)->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGroups(): void
    {
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]">
        <optgroup label="Russia">
        <option value="2"> Moscu</option>
        <option value="3"> San Petersburgo</option>
        <option value="4"> Novosibirsk</option>
        <option value="5"> Ekaterinburgo</option>
        </optgroup>
        <optgroup label="Chile">
        <option value="6">Santiago</option>
        <option value="7">Concepcion</option>
        <option value="8">Chillan</option>
        </optgroup>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()
                ->for(new PropertyType(), 'int')
                ->groups($this->groups)
                ->items($this->citiesGroups)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGroupsItemsAttributes(): void
    {
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]">
        <optgroup label="Russia">
        <option value="2" disabled> Moscu</option>
        <option value="3"> San Petersburgo</option>
        <option value="4"> Novosibirsk</option>
        <option value="5"> Ekaterinburgo</option>
        </optgroup>
        <optgroup label="Chile">
        <option value="6">Santiago</option>
        <option value="7">Concepcion</option>
        <option value="8">Chillan</option>
        </optgroup>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()
                ->for(new PropertyType(), 'int')
                ->items($this->citiesGroups)
                ->itemsAttributes(['2' => ['disabled' => true]])
                ->groups($this->groups)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <select id="id-test" name="PropertyType[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new PropertyType(), 'int')->id('id-test')->items($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testItems(): void
    {
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]">
        <option class="test-class" value="1">Moscu</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()
                ->for(new PropertyType(), 'int')
                ->items([1 => 'Moscu'])
                ->itemsAttributes([1 => ['class' => 'test-class']])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $select = Select::widget();
        $this->assertNotSame($select, $select->groups());
        $this->assertNotSame($select, $select->items());
        $this->assertNotSame($select, $select->itemsAttributes());
        $this->assertNotSame($select, $select->multiple());
        $this->assertNotSame($select, $select->optionsData([]));
        $this->assertNotSame($select, $select->prompt(''));
        $this->assertNotSame($select, $select->promptTag(null));
        $this->assertNotSame($select, $select->size(0));
        $this->assertNotSame($select, $select->unselectValue(null));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMultiple(): void
    {
        $formModel = new PropertyType();
        $formModel->set('array', [1, 4]);
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[array]" value="0">
        <select id="propertytype-array" name="PropertyType[array][]" multiple size="4">
        <option value="1" selected>Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4" selected>Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()
                ->for($formModel, 'array')
                ->multiple()
                ->items($this->cities)
                ->unselectValue('0')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <select id="propertytype-int" name="name-test">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new PropertyType(), 'int')->items($this->cities)->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testOptionsDataWithEncode(): void
    {
        $cities = [
            '1' => '<b>Moscu</b>',
            '2' => 'San Petersburgo',
            '3' => 'Novosibirsk',
            '4' => 'Ekaterinburgo',
        ];
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1">&lt;b&gt;Moscu&lt;/b&gt;</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new PropertyType(), 'int')->encode(true)->optionsData($cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPrompt(): void
    {
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]">
        <option value>Select City Birth</option>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()
                ->for(new PropertyType(), 'int')
                ->items($this->cities)
                ->prompt('Select City Birth')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPromptTag(): void
    {
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="0" selected>Select City Birth</option>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()
                ->for(new PropertyType(), 'int')
                ->items($this->cities)
                ->promptTag(Option::tag()->content('Select City Birth')->value(0))
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]" required>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new PropertyType(), 'int')->items($this->cities)->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new PropertyType(), 'int')->items($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSizeWithMultiple(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[int]" value>
        <select id="propertytype-int" name="PropertyType[int][]" multiple size="3">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()
                ->for(new PropertyType(), 'int')
                ->items($this->cities)
                ->multiple()
                ->size(3)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]" tabindex="1">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new PropertyType(), 'int')->items($this->cities)->tabIndex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testUnselectValueWithMultiple(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="PropertyType[array]" value="0">
        <select id="propertytype-array" name="PropertyType[array][]" multiple size="4">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()
                ->for(new PropertyType(), 'array')
                ->items($this->cities)
                ->multiple(true)
                ->unselectValue('0')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value int `1`.
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1" selected>Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new PropertyType(), 'int')->items($this->cities)->value(1)->render(),
        );

        // Value int `2`.
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new PropertyType(), 'int')->items($this->cities)->value(2)->render(),
        );

        // Value iterable `[2, 3]`.
        $expected = <<<HTML
        <select id="propertytype-array" name="PropertyType[array]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3" selected>Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new PropertyType(), 'array')->items($this->cities)->value([2, 3])->render(),
        );

        // Value string `1`.
        $expected = <<<HTML
        <select id="propertytype-string" name="PropertyType[string]">
        <option value="1" selected>Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new PropertyType(), 'string')->items($this->cities)->value('1')->render(),
        );

        // Value string `2`.
        $expected = <<<HTML
        <select id="propertytype-string" name="PropertyType[string]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new PropertyType(), 'string')->items($this->cities)->value('2')->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new PropertyType(), 'int')->items($this->cities)->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $formModel = new PropertyType();

        // Value object `stdClass`.
        $formModel->set('object', new stdClass());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Select widget value can not be an object.');
        Select::widget()->for($formModel, 'object')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value int `1`.
        $formModel->set('int', 1);
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1" selected>Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for($formModel, 'int')->items($this->cities)->render(),
        );

        // Value int `2`.
        $formModel->set('int', 2);
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for($formModel, 'int')->items($this->cities)->render(),
        );

        // Value iterable `[2, 3]`.
        $formModel->set('array', [2, 3]);
        $expected = <<<HTML
        <select id="propertytype-array" name="PropertyType[array]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3" selected>Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for($formModel, 'array')->items($this->cities)->render(),
        );

        // Value string `1`.
        $formModel->set('string', '1');
        $expected = <<<HTML
        <select id="propertytype-string" name="PropertyType[string]">
        <option value="1" selected>Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for($formModel, 'string')->items($this->cities)->render(),
        );

        // Value string `2`.
        $formModel->set('string', 2);
        $expected = <<<HTML
        <select id="propertytype-string" name="PropertyType[string]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for($formModel, 'string')->items($this->cities)->render(),
        );

        // Value `null`.
        $formModel->set('int', null);
        $expected = <<<HTML
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for($formModel, 'int')->items($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <select name="PropertyType[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new PropertyType(), 'int')->id(null)->items($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <select id="propertytype-int">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Select::widget()->for(new PropertyType(), 'int')->items($this->cities)->name(null)->render(),
        );
    }
}
