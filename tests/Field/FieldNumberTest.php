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

final class FieldNumberTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number" name="PropertyType[number]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->autofocus()->number(new PropertyType(), 'number')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number" name="PropertyType[number]" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->disabled()->number(new PropertyType(), 'number')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeNumber(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="validatorrules-number">Number</label>
        <input type="number" id="validatorrules-number" name="ValidatorRules[number]" value="0" max="5" min="3">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->number(new ValidatorRules(), 'number')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="validatorrules-numberrequired">Number Required</label>
        <input type="number" id="validatorrules-numberrequired" name="ValidatorRules[numberRequired]" value="0" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new ValidatorRules(), 'numberRequired')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="id-test">Number</label>
        <input type="number" id="id-test" name="PropertyType[number]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id('id-test')->number(new PropertyType(), 'number')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMax(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number" name="PropertyType[number]" max="8">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new PropertyType(), 'number', ['max()' => [8]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMin(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number" name="PropertyType[number]" min="4">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new PropertyType(), 'number', ['min()' => [4]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number" name="name-test">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name('name-test')->number(new PropertyType(), 'number')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number" name="PropertyType[number]" placeholder="PlaceHolder Text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new PropertyType(), 'number')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number" name="PropertyType[number]" readonly>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new PropertyType(), 'number')->readonly()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number" name="PropertyType[number]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new PropertyType(), 'number')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number" name="PropertyType[number]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->number(new PropertyType(), 'number')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number" name="PropertyType[number]" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new PropertyType(), 'number')->tabindex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value int `1`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number" name="PropertyType[number]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new PropertyType(), 'number')->value(1)->render(),
        );

        // Value numeric string `1`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="number" id="propertytype-string" name="PropertyType[string]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new PropertyType(), 'string')->value('1')->render(),
        );

        // Value `null`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number" name="PropertyType[number]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new PropertyType(), 'number')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Number widget must be a numeric or null value.');
        Field::widget()->number(new PropertyType(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value int `1`.
        $formModel->setValue('number', 1);
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number" name="PropertyType[number]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number($formModel, 'number')->render(),
        );

        // Value numeric string `1`.
        $formModel->setValue('string', '1');
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="number" id="propertytype-string" name="PropertyType[string]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->setValue('number', null);
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number" name="PropertyType[number]" value="0">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number($formModel, 'number')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<'HTML'
        <div>
        <label>Number</label>
        <input type="number" name="PropertyType[number]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->id(null)->number(new PropertyType(), 'number')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-number">Number</label>
        <input type="number" id="propertytype-number">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name(null)->number(new PropertyType(), 'number')->render(),
        );
    }
}
