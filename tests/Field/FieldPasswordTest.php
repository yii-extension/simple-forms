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

final class FieldPasswordTest extends TestCase
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
        <input type="password" id="propertytype-string" name="PropertyType[string]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->autofocus()->password(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="password" id="propertytype-string" name="PropertyType[string]" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->disabled()->password(new PropertyType(), 'string')->render(),
        );
    }

    public function testGetValidatorAttributeRegex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-regex">Regex</label>
        <input type="password" id="validatorrules-regex" name="ValidatorRules[regex]" pattern="\w+">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->password(new ValidatorRules(), 'regex')->render(),
        );
    }

    public function testGetValidatorAttributeMaxLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-maxlength">Maxlength</label>
        <input type="password" id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->password(new ValidatorRules(), 'maxlength')->render());
    }

    public function testGetValidatorAttributeMinLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-minlength">Minlength</label>
        <input type="password" id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->password(new ValidatorRules(), 'minlength')->render());
    }

    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-required">Required</label>
        <input type="password" id="validatorrules-required" name="ValidatorRules[required]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->password(new ValidatorRules(), 'required')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">String</label>
        <input type="password" id="id-test" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->id('id-test')->password(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMaxLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="password" id="propertytype-string" name="PropertyType[string]" maxlength="16">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->password(new PropertyType(), 'string', ['maxlength()' => [16]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMinLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="password" id="propertytype-string" name="PropertyType[string]" minlength="8">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->password(new PropertyType(), 'string', ['minlength()' => [8]])->render(),
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
        <input type="password" id="propertytype-string" name="name-test">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->name('name-test')->password(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPattern(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="password" id="propertytype-string" name="PropertyType[string]" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->password(new PropertyType(), 'string', ['pattern()' => ['(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}']])
                ->title(
                    'Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters.'
                )
                ->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="password" id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->password(new PropertyType(), 'string')->placeHolder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="password" id="propertytype-string" name="PropertyType[string]" readonly>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->readonly()->password(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="password" id="propertytype-string" name="PropertyType[string]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->password(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="password" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->password(new PropertyType(), 'string')->render(),
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
        <input type="password" id="propertytype-string" name="PropertyType[string]" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->password(new PropertyType(), 'string')->tabIndex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `1234??`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="password" id="propertytype-string" name="PropertyType[string]" value="1234??">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->password(new PropertyType(), 'string')->value('1234??')->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="password" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->password(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password widget must be a string or null value.');
        Field::create()->password(new PropertyType(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `1234??`.
        $formModel->setValue('string', '1234??');
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="password" id="propertytype-string" name="PropertyType[string]" value="1234??">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->password($formModel, 'string')->render());

        // Value `null`.
        $formModel->setValue('string', null);
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="password" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->password($formModel, 'string')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label>String</label>
        <input type="password" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->id(null)->password(new PropertyType(), 'string')->render(),
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
        <input type="password" id="propertytype-string">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->name(null)->password(new PropertyType(), 'string')->render(),
        );
    }
}
