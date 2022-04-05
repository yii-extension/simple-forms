<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use StdClass;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Tag\Option;

final class FieldSelectTest extends TestCase
{
    use TestTrait;

    /** @var string[] */
    private array $cities = [
        '1' => 'Moscu',
        '2' => 'San Petersburgo',
        '3' => 'Novosibirsk',
        '4' => 'Ekaterinburgo',
    ];
    /** @var string[][] */
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
    /** @var string[][] */
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
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="PropertyType[int]" autofocus>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->autofocus()->select(new PropertyType(), 'int', ['items()' => [$this->cities]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="PropertyType[int]" disabled>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->disabled()->select(new PropertyType(), 'int', ['items()' => [$this->cities]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-required">Required</label>
        <select id="validatorrules-required" name="ValidatorRules[required]" required>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select(new ValidatorRules(), 'required', ['items()' => [$this->cities]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGroups(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
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
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new PropertyType(), 'int', ['items()' => [$this->citiesGroups], 'groups()' => [$this->groups]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGroupsItemsAttributes(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
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
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(
                    new PropertyType(),
                    'int',
                    [
                        'items()' => [$this->citiesGroups],
                        'groups()' => [$this->groups],
                        'itemsAttributes()' => [['2' => ['disabled' => true]]],
                    ],
                )
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">Int</label>
        <select id="id-test" name="PropertyType[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id('id-test')->select(new PropertyType(), 'int', ['items()' => [$this->cities]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMultiple(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-array">Array</label>
        <input type="hidden" name="PropertyType[array]" value="0">
        <select id="propertytype-array" name="PropertyType[array][]" multiple size="4">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(
                    new PropertyType(),
                    'array',
                    ['items()' => [$this->cities], 'unselectValue()' => ['0'], 'multiple()' => [true]],
                )
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="name-test">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name('name-test')->select(new PropertyType(), 'int', ['items()' => [$this->cities]])->render(),
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
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1">&lt;b&gt;Moscu&lt;/b&gt;</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->encode(true)->select(new PropertyType(), 'int', ['optionsData()' => [$cities]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPrompt(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="PropertyType[int]">
        <option value>Select City Birth</option>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new PropertyType(), 'int', ['items()' => [$this->cities], 'prompt()' => ['Select City Birth']])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPromptTag(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="0" selected>Select City Birth</option>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(
                    new PropertyType(),
                    'int',
                    [
                        'items()' => [$this->cities],
                        'promptTag()' => [Option::tag()->content('Select City Birth')->value(0)],
                    ],
                )
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="PropertyType[int]" required>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select(new PropertyType(), 'int', ['items()' => [$this->cities]])->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select(new PropertyType(), 'int', ['items()' => [$this->cities]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSizeWithMultiple(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="hidden" name="PropertyType[int]" value>
        <select id="propertytype-int" name="PropertyType[int][]" multiple size="4">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new PropertyType(), 'int', ['items()' => [$this->cities], 'multiple()' => [true], 'size()' => [4]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="PropertyType[int]" tabindex="1">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select(new PropertyType(), 'int', ['items()' => [$this->cities]])->tabindex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testUnselectValueWithMultiple(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-array">Array</label>
        <input type="hidden" name="PropertyType[array]" value="0">
        <select id="propertytype-array" name="PropertyType[array][]" multiple size="4">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(
                    new PropertyType(),
                    'array',
                    ['items()' => [$this->cities], 'unselectValue()' => ['0'], 'multiple()' => [true]],
                )
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
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1" selected>Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select(new PropertyType(), 'int', ['items()' => [$this->cities]])->value(1)->render(),
        );

        // Value int `2`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select(new PropertyType(), 'int', ['items()' => [$this->cities]])->value(2)->render(),
        );

        // Value iterable `[2, 3]`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-array">Array</label>
        <select id="propertytype-array" name="PropertyType[array]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3" selected>Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select(new PropertyType(), 'array', ['items()' => [$this->cities]])->value([2, 3])->render(),
        );

        // Value string `1`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <select id="propertytype-string" name="PropertyType[string]">
        <option value="1" selected>Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select(new PropertyType(), 'string', ['items()' => [$this->cities]])->value('1')->render(),
        );

        // Value string `2`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <select id="propertytype-string" name="PropertyType[string]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select(new PropertyType(), 'string', ['items()' => [$this->cities]])->value('2')->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select(new PropertyType(), 'int', ['items()' => [$this->cities]])->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $formModel = new PropertyType();

        // Value object `stdClass`.
        $formModel->setValue('object', new StdClass());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Select widget value can not be an object.');
        Field::widget()->select($formModel, 'object')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value int `1`.
        $formModel->setValue('int', 1);
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1" selected>Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select($formModel, 'int', ['items()' => [$this->cities]])->render(),
        );

        // Value int `2`.
        $formModel->setValue('int', 2);
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select($formModel, 'int', ['items()' => [$this->cities]])->render(),
        );

        // Value iterable `[2, 3]`.
        $formModel->setValue('array', [2, 3]);
        $expected = <<<HTML
        <div>
        <label for="propertytype-array">Array</label>
        <select id="propertytype-array" name="PropertyType[array]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3" selected>Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select($formModel, 'array', ['items()' => [$this->cities]])->render(),
        );

        // Value string `1`.
        $formModel->setValue('string', '1');
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <select id="propertytype-string" name="PropertyType[string]">
        <option value="1" selected>Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select($formModel, 'string', ['items()' => [$this->cities]])->render(),
        );

        // Value string '2'.
        $formModel->setValue('string', '2');
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <select id="propertytype-string" name="PropertyType[string]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select($formModel, 'string', ['items()' => [$this->cities]])->render(),
        );

        // Value `null`.
        $formModel->setValue('int', null);
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int" name="PropertyType[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select($formModel, 'int', ['items()' => [$this->cities]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label>Int</label>
        <select name="PropertyType[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select(new PropertyType(), 'int', ['items()' => [$this->cities]])->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <select id="propertytype-int">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->select(new PropertyType(), 'int', ['items()' => [$this->cities]])->name(null)->render(),
        );
    }
}
