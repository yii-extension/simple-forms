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

final class FieldTextTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->autofocus()->text(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDirname(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" dirname="test.dir">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->text(new PropertyType(), 'string', ['dirname()' => ['test.dir']])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        Field::create()->text(new PropertyType(), 'string', ['dirname()' => ['']])->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->disabled()->text(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMatchRegulRegex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-regex">Regex</label>
        <input type="text" id="validatorrules-regex" name="ValidatorRules[regex]" pattern="\w+">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->text(new ValidatorRules(), 'regex')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-maxlength">Maxlength</label>
        <input type="text" id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->text(new ValidatorRules(), 'maxlength')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-minlength">Minlength</label>
        <input type="text" id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->text(new ValidatorRules(), 'minlength')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-required">Required</label>
        <input type="text" id="validatorrules-required" name="ValidatorRules[required]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->text(new ValidatorRules(), 'required')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">String</label>
        <input type="text" id="id-test" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->id('id-test')->text(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMaxLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" maxlength="10">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->text(new PropertyType(), 'string', ['maxlength()' => [10]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMinLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" minlength="4">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->text(new PropertyType(), 'string', ['minlength()' => [4]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="name-test">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->name('name-test')->text(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" title="Only accepts uppercase and lowercase letters." pattern="[A-Za-z]">
        </div>
        HTML;
        $html = Field::create()
            ->text(new PropertyType(), 'string', ['pattern()' => ['[A-Za-z]']])
            ->title('Only accepts uppercase and lowercase letters.')
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->placeholder('PlaceHolder Text')->text(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" readonly>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->readonly()->text(new PropertyType(), 'string')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->required()->text(new PropertyType(), 'string')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->text(new PropertyType(), 'string')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSize(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" size="10">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->text(new PropertyType(), 'string', ['size()' => [10]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->tabIndex(1)->text(new PropertyType(), 'string')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `joe`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" value="joe">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->text(new PropertyType(), 'string')->value('joe')->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->text(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Text widget must be a string or null value.');
        Field::create()->text(new PropertyType(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithForm(): void
    {
        $formModel = new PropertyType();

        // Value string `joe`.
        $formModel->setValue('string', 'joe');
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" value="joe">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->text($formModel, 'string')->render());

        // Value `null`.
        $formModel->setValue('string', null);
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->text($formModel, 'string')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label>String</label>
        <input type="text" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->id(null)->text(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->name(null)->text(new PropertyType(), 'string')->render());
    }
}
