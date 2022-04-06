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

final class FieldEmailTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="email" id="propertytype-string" name="PropertyType[string]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->autofocus()->email(new PropertyType(), 'string')->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="email" id="propertytype-string" name="PropertyType[string]" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->disabled()->email(new PropertyType(), 'string')->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRegex(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="validatorrules-regex">Regex</label>
        <input type="email" id="validatorrules-regex" name="ValidatorRules[regex]" pattern="\w+">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->email(new ValidatorRules(), 'regex')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="validatorrules-maxlength">Maxlength</label>
        <input type="email" id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->email(new ValidatorRules(), 'maxlength')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="validatorrules-minlength">Minlength</label>
        <input type="email" id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->email(new ValidatorRules(), 'minlength')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="validatorrules-required">Required</label>
        <input type="email" id="validatorrules-required" name="ValidatorRules[required]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->email(new ValidatorRules(), 'required')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="id-test">String</label>
        <input type="email" id="id-test" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->email(new PropertyType(), 'string')->id('id-test')->render(),
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
        <input type="email" id="propertytype-string" name="PropertyType[string]" maxlength="10">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->email(new PropertyType(), 'string', ['maxlength()' => [10]])->render(),
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
        <input type="email" id="propertytype-string" name="PropertyType[string]" minlength="4">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->email(new PropertyType(), 'string', ['minlength()' => [4]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMultiple(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="email" id="propertytype-string" name="PropertyType[string]" value="email1@example.com;email2@example.com;" multiple>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->email(new PropertyType(), 'string', ['multiple()' => [true]])
                ->value('email1@example.com;email2@example.com;')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="email" id="propertytype-string" name="name-test">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->email(new PropertyType(), 'string')->name('name-test')->render(),
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
        <input type="email" id="propertytype-string" name="PropertyType[string]" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->email(new PropertyType(), 'string', ['pattern()' => ['[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}']])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="email" id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->email(new PropertyType(), 'string')->placeholder('PlaceHolder Text')->render(),
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
        <input type="email" id="propertytype-string" name="PropertyType[string]" readonly>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->email(new PropertyType(), 'string')->readonly()->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="email" id="propertytype-string" name="PropertyType[string]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->email(new PropertyType(), 'string')->required()->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="email" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->email(new PropertyType(), 'string')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSize(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="email" id="propertytype-string" name="PropertyType[string]" size="20">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->email(new PropertyType(), 'string', ['size()' => [20]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="email" id="propertytype-string" name="PropertyType[string]" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->email(new PropertyType(), 'string')->tabindex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `email1@example.com;`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="email" id="propertytype-string" name="PropertyType[string]" value="email1@example.com;">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->email(new PropertyType(), 'string')->value('email1@example.com;')->render(),
        );

        // Value `null`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="email" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->email(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email widget must be a string or null value.');
        Field::create()->email(new PropertyType(), 'int')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `email1@example.com;`.
        $formModel->setValue('string', 'email1@example.com;');
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="email" id="propertytype-string" name="PropertyType[string]" value="email1@example.com;">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->email($formModel, 'string')->render());

        // Value `null`.
        $formModel->setValue('string', null);
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="email" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->email($formModel, 'string')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<'HTML'
        <div>
        <label>String</label>
        <input type="email" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->email(new PropertyType(), 'string')->id(null)->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="email" id="propertytype-string">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->email(new PropertyType(), 'string')->name(null)->render()
        );
    }
}
