<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class FieldUrlTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->autofocus()->url(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->disabled()->url(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">String</label>
        <input type="url" id="id-test" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->id('id-test')->url(new PropertyType(), 'string')->render()
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRegex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-regex">Regex</label>
        <input type="url" id="validatorrules-regex" name="ValidatorRules[regex]" pattern="\w+">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->url(new ValidatorRules(), 'regex')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-maxlength">Maxlength</label>
        <input type="url" id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->url(new ValidatorRules(), 'maxlength')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-minlength">Minlength</label>
        <input type="url" id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->url(new ValidatorRules(), 'minlength')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-required">Required</label>
        <input type="url" id="validatorrules-required" name="ValidatorRules[required]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->url(new ValidatorRules(), 'required')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeUrlValidator(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorrules-url">Url</label>
        <input type="url" id="validatorrules-url" name="ValidatorRules[url]" pattern="^([hH][tT][tT][pP]|[hH][tT][tT][pP][sS]):\/\/(([a-zA-Z0-9][a-zA-Z0-9_-]*)(\.[a-zA-Z0-9][a-zA-Z0-9_-]*)+)(?::\d{1,5})?([?\/#].*$|$)">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->url(new ValidatorRules(), 'url')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testMaxLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]" maxlength="10">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->url(new PropertyType(), 'string', ['maxlength()' => [10]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMinLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]" minlength="4">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->url(new PropertyType(), 'string', ['minlength()' => [4]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="name-test">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->name('name-test')->url(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]" pattern="^(http(s)?:\/\/)+[\w\-\._~:\/?#[\]@!$&amp;&apos;\(\)\*\+,;=.]+$">
        </div>
        HTML;
        $html = Field::create()
            ->url(new PropertyType(), 'string', ['pattern()' => ["^(http(s)?:\/\/)+[\w\-\._~:\/?#[\]@!\$&'\(\)\*\+,;=.]+$"]])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @throws ReflectionException
     */
    public function testPlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->placeholder('PlaceHolder Text')->url(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testReadonly(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]" readonly>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->readonly()->url(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->required()->url(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->url(new PropertyType(), 'string')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testSize(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]" size="20">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->url(new PropertyType(), 'string', ['size()' => [20]])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->url(new PropertyType(), 'string')->tabIndex(1)->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value string `https://yiiframework.com`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]" value="https://yiiframework.com">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->url(new PropertyType(), 'string')->value('https://yiiframework.com')->render(),
        );

        // Value `null`.
        $expected = <<<'HTML'
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->url(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Url widget must be a string or null value.');
        Field::create()->url(new PropertyType(), 'int')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithForm(): void
    {
        $formModel = new PropertyType();

        // Value string `'https://yiiframework.com'`.
        $formModel->setValue('string', 'https://yiiframework.com');
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]" value="https://yiiframework.com">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->url($formModel, 'string')->render());

        // Value `null`.
        $formModel->setValue('string', null);
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->url($formModel, 'string')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label>String</label>
        <input type="url" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->id(null)->url(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="url" id="propertytype-string">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->name(null)->url(new PropertyType(), 'string')->render(),
        );
    }
}
