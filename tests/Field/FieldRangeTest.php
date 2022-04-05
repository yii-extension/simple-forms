<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Html;

final class FieldRangeTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" autofocus oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->autofocus()->range(new PropertyType(), 'int')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" disabled oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->disabled()->range(new PropertyType(), 'int')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeNumber(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label for="validatorrules-number">Number</label>
        <input type="range" id="validatorrules-number" name="ValidatorRules[number]" value="0" max="5" min="3" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="ValidatorRules[number]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->range(new ValidatorRules(), 'number')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label for="validatorrules-numberrequired">Number Required</label>
        <input type="range" id="validatorrules-numberrequired" name="ValidatorRules[numberRequired]" value="0" required oninput="i1.value=this.value">
        <output id="i1" name="i1" for="ValidatorRules[numberRequired]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->range(new ValidatorRules(), 'numberRequired')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label for="id-test">Int</label>
        <input type="range" id="id-test" name="PropertyType[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id('id-test')->range(new PropertyType(), 'int')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMax(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" max="8" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->range(new PropertyType(), 'int', ['max()' => [8]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMin(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" min="4" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->range(new PropertyType(), 'int', ['min()' => [4]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" name="name-test" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="name-test">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name('name-test')->range(new PropertyType(), 'int')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testOutputAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" class="test-class" name="i1" for="PropertyType[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->range(new PropertyType(), 'int', ['outputAttributes()' => [['class' => 'test-class']]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testOutputTag(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" oninput="i1.value=this.value">
        <p id="i1" name="i1" for="PropertyType[int]">0</p>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->range(new PropertyType(), 'int', ['outputTag()' => ['p']])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testOutputTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The output tag name it cannot be empty value.');
        Field::widget()->range(new PropertyType(), 'int', ['outputTag()' => ['']])->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" required oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->range(new PropertyType(), 'int')->required()->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->range(new PropertyType(), 'int')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabindex(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" tabindex="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->range(new PropertyType(), 'int')->tabindex(1)->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        // Value int `1`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">1</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->range(new PropertyType(), 'int')->value(1)->render());

        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        // Value string numeric `1`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="range" id="propertytype-string" name="PropertyType[string]" value="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[string]">1</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->range(new PropertyType(), 'string')->value('1')->render()
        );

        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        // Value `null`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->range(new PropertyType(), 'int')->value(null)->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Range widget must be a numeric or null value.');
        Field::widget()->range(new PropertyType(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        // Value int `1`.
        $formModel->setValue('int', '1');
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">1</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->range($formModel, 'int')->render());

        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        // Value string numeric `1`.
        $formModel->setValue('string', '1');
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="range" id="propertytype-string" name="PropertyType[string]" value="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[string]">1</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->range($formModel, 'string')->render());

        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        // Value `null`.
        $formModel->setValue('int', null);
        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" name="PropertyType[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->range($formModel, 'int')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label>Int</label>
        <input type="range" name="PropertyType[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="PropertyType[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->id(null)->range(new PropertyType(), 'int')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <label for="propertytype-int">Int</label>
        <input type="range" id="propertytype-int" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name(null)->range(new PropertyType(), 'int')->render()
        );
    }
}
