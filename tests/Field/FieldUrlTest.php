<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\ValidatorForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class FieldUrlTest extends TestCase
{
    use TestTrait;

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->autofocus()->url(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->disabled()->url(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">String</label>
        <input type="url" id="id-test" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id('id-test')->url(new TypeForm(), 'string')->render()
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorMatchRegularExpression(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-matchregular">Matchregular</label>
        <input type="url" id="validatorform-matchregular" name="ValidatorForm[matchregular]" pattern="\w+">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->url(new ValidatorForm(), 'matchregular')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-maxlength">Maxlength</label>
        <input type="url" id="validatorform-maxlength" name="ValidatorForm[maxlength]" maxlength="50">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->url(new ValidatorForm(), 'maxlength')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-minlength">Minlength</label>
        <input type="url" id="validatorform-minlength" name="ValidatorForm[minlength]" minlength="15">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->url(new ValidatorForm(), 'minlength')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-required">Required</label>
        <input type="url" id="validatorform-required" name="ValidatorForm[required]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->url(new ValidatorForm(), 'required')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeUrlValidator(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-url">Url</label>
        <input type="url" id="validatorform-url" name="ValidatorForm[url]" pattern="^([hH][tT][tT][pP]|[hH][tT][tT][pP][sS]):\/\/(([a-zA-Z0-9][a-zA-Z0-9_-]*)(\.[a-zA-Z0-9][a-zA-Z0-9_-]*)+)(?::\d{1,5})?([?\/#].*$|$)">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->url(new ValidatorForm(), 'url')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMaxLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" maxlength="10">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->url(new TypeForm(), 'string', ['maxlength()' => [10]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMinLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" minlength="4">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->url(new TypeForm(), 'string', ['minlength()' => [4]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="name-test">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name('name-test')->url(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testPattern(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" pattern="^(http(s)?:\/\/)+[\w\-\._~:\/?#[\]@!$&amp;&apos;\(\)\*\+,;=.]+$">
        </div>
        HTML;
        $html = Field::widget()
            ->url(
                new TypeForm(),
                'string',
                ['pattern()' => ["^(http(s)?:\/\/)+[\w\-\._~:\/?#[\]@!\$&'\(\)\*\+,;=.]+$"]],
            )
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testPlaceholder(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->placeholder('PlaceHolder Text')->url(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testReadOnly(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" readonly>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->addAttribute('readonly', true)->url(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->required()->url(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->url(new TypeForm(), 'string')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testSize(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" size="20">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->url(new TypeForm(), 'string', ['size()' => [20]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->url(new TypeForm(), 'string')->tabIndex(1)->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValue(): void
    {
        // Value string `'https://yiiframework.com'`.
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" value="https://yiiframework.com">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->url(new TypeForm(), 'string')->value('https://yiiframework.com')->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->url(new TypeForm(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Url widget must be a string or null value.');
        Field::widget()->url(new TypeForm(), 'array')->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueWithForm(): void
    {
        $formModel = new TypeForm();

        // Value string `'https://yiiframework.com'`.
        $formModel->setAttribute('string', 'https://yiiframework.com');
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" value="https://yiiframework.com">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->url($formModel, 'string')->render());

        // Value `null`.
        $formModel->setAttribute('string', null);
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->url($formModel, 'string')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label>String</label>
        <input type="url" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id(null)->url(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name(null)->url(new TypeForm(), 'string')->render(),
        );
    }
}
