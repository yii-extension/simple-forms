<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\ValidatorForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yii\Extension\Simple\Forms\Url;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class UrlTest extends TestCase
{
    use TestTrait;

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" autofocus>',
            Url::widget()->autofocus()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDisabled(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="url" id="typeform-string" name="TypeForm[string]" disabled>',
            Url::widget()->disabled()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorMatchRegularExpression(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorform-matchregular" name="ValidatorForm[matchregular]" pattern="\w+">',
            Url::widget()->for(new ValidatorForm(), 'matchregular')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorform-maxlength" name="ValidatorForm[maxlength]" maxlength="50">',
            Url::widget()->for(new ValidatorForm(), 'maxlength')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorform-minlength" name="ValidatorForm[minlength]" minlength="15">',
            Url::widget()->for(new ValidatorForm(), 'minlength')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorform-required" name="ValidatorForm[required]" required>',
            Url::widget()->for(new ValidatorForm(), 'required')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeUrlValidator(): void
    {
        $expected = <<<HTML
        <input type="url" id="validatorform-url" name="ValidatorForm[url]" pattern="^([hH][tT][tT][pP]|[hH][tT][tT][pP][sS]):\/\/(([a-zA-Z0-9][a-zA-Z0-9_-]*)(\.[a-zA-Z0-9][a-zA-Z0-9_-]*)+)(?::\d{1,5})?([?\/#].*$|$)">
        HTML;
        $this->assertSame($expected, Url::widget()->for(new ValidatorForm(), 'url')->render());
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="url" id="id-test" name="TypeForm[string]">',
            Url::widget()->for(new TypeForm(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testImmutability(): void
    {
        $url = Url::widget();
        $this->assertNotSame($url, $url->maxlength(0));
        $this->assertNotSame($url, $url->minlength(0));
        $this->assertNotSame($url, $url->pattern(''));
        $this->assertNotSame($url, $url->placeholder(''));
        $this->assertNotSame($url, $url->size(0));
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" maxlength="10">',
            Url::widget()->for(new TypeForm(), 'string')->maxlength(10)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" minlength="4">',
            Url::widget()->for(new TypeForm(), 'string')->minlength(4)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="name-test">',
            Url::widget()->for(new TypeForm(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testPattern(): void
    {
        $expected = <<<HTML
        <input type="url" id="typeform-string" name="TypeForm[string]" pattern="^(http(s)?:\/\/)+[\w\-\._~:\/?#[\]@!$&amp;&apos;\(\)\*\+,;=.]+$">
        HTML;
        $html = Url::widget()
            ->for(new TypeForm(), 'string')
            ->pattern("^(http(s)?:\/\/)+[\w\-\._~:\/?#[\]@!\$&'\(\)\*\+,;=.]+$")
            ->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text">',
            Url::widget()->for(new TypeForm(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testReadOnly(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" readonly>',
            Url::widget()->for(new TypeForm(), 'string')->readOnly()->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" required>',
            Url::widget()->for(new TypeForm(), 'string')->required()->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]">',
            Url::widget()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testSize(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" size="20">',
            Url::widget()->for(new TypeForm(), 'string')->size(20)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testTabIndex(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="url" id="typeform-string" name="TypeForm[string]" tabindex="1">',
            Url::widget()->for(new TypeForm(), 'string')->tabIndex(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValue(): void
    {
        // Value `null`.
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]">',
            Url::widget()->for(new TypeForm(), 'string')->value(null)->render(),
        );

        // Value string `https://yiiframework.com`
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" value="https://yiiframework.com">',
            Url::widget()->for(new TypeForm(), 'string')->value('https://yiiframework.com')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Url widget must be a string or null value.');
        Url::widget()->for(new TypeForm(), 'array')->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueWithForm(): void
    {
        $formModel = new TypeForm();

        // Value `null`.
        $formModel->setAttribute('string', null);
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]">',
            Url::widget()->for($formModel, 'string')->render(),
        );

        // Value string `https://yiiframework.com`.
        $formModel->setAttribute('string', 'https://yiiframework.com');
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" value="https://yiiframework.com">',
            Url::widget()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="url" name="TypeForm[string]">',
            Url::widget()->for(new TypeForm(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string">',
            Url::widget()->for(new TypeForm(), 'string')->name(null)->render(),
        );
    }
}
