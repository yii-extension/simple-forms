<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\ValidatorForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class FieldUrlTest extends TestCase
{
    use TestTrait;

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
            Field::widget()->id('id-test')->url(new TypeForm(), 'string')->render(),
        );
    }

    public function testGetValidatorMatchRegularExpression(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-matchregular">Matchregular</label>
        <input type="url" id="validatorform-matchregular" name="ValidatorForm[matchregular]" pattern="\w+">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->url(new ValidatorForm(), 'matchregular')->render(),
        );
    }

    public function testGetValidatorAttributeMaxLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-maxlength">Maxlength</label>
        <input type="url" id="validatorform-maxlength" name="ValidatorForm[maxlength]" maxlength="50">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->url(new ValidatorForm(), 'maxlength')->render(),
        );
    }

    public function testGetValidatorAttributeMinLength(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-minlength">Minlength</label>
        <input type="url" id="validatorform-minlength" name="ValidatorForm[minlength]" minlength="15">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->url(new ValidatorForm(), 'minlength')->render(),
        );
    }

    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-required">Required</label>
        <input type="url" id="validatorform-required" name="ValidatorForm[required]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->url(new ValidatorForm(), 'required')->render(),
        );
    }

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
            Field::widget()->readonly()->url(new TypeForm(), 'string')->render(),
        );
    }

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

    public function testValue(): void
    {
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
    }

    public function testValueWithForm(): void
    {
        $formModel = new TypeForm();

        // Value `null`.
        $formModel->setAttribute('string', null);
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->url($formModel, 'string')->render());

        // Value string `'https://yiiframework.com'`.
        $formModel->setAttribute('string', 'https://yiiframework.com');
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="url" id="typeform-string" name="TypeForm[string]" value="https://yiiframework.com">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->url($formModel, 'string')->render());
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Url widget must be a string or null value.');
        Field::widget()->url(new TypeForm(), 'array')->render();
    }

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
