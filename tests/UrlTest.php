<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\ValidatorForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yii\Extension\Simple\Forms\Url;

final class UrlTest extends TestCase
{
    use TestTrait;

    public function testGetValidatorMatchRegularExpression(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorform-matchregular" name="ValidatorForm[matchregular]" pattern="\w+">',
            Url::widget()->for(new ValidatorForm(), 'matchregular')->render(),
        );
    }

    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorform-maxlength" name="ValidatorForm[maxlength]" maxlength="50">',
            Url::widget()->for(new ValidatorForm(), 'maxlength')->render(),
        );
    }

    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorform-minlength" name="ValidatorForm[minlength]" minlength="15">',
            Url::widget()->for(new ValidatorForm(), 'minlength')->render(),
        );
    }

    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorform-required" name="ValidatorForm[required]" required>',
            Url::widget()->for(new ValidatorForm(), 'required')->render(),
        );
    }

    public function testGetValidatorAttributeUrlValidator(): void
    {
        $expected = <<<HTML
        <input type="url" id="validatorform-url" name="ValidatorForm[url]" pattern="^([hH][tT][tT][pP]|[hH][tT][tT][pP][sS]):\/\/(([a-zA-Z0-9][a-zA-Z0-9_-]*)(\.[a-zA-Z0-9][a-zA-Z0-9_-]*)+)(?::\d{1,5})?([?\/#].*$|$)">
        HTML;
        $this->assertSame($expected, Url::widget()->for(new ValidatorForm(), 'url')->render());
    }

    public function testImmutability(): void
    {
        $url = Url::widget();
        $this->assertNotSame($url, $url->maxlength(0));
        $this->assertNotSame($url, $url->minlength(0));
        $this->assertNotSame($url, $url->pattern(''));
        $this->assertNotSame($url, $url->placeholder(''));
        $this->assertNotSame($url, $url->size(0));
    }

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" maxlength="10">',
            Url::widget()->for(new TypeForm(), 'string')->maxlength(10)->render(),
        );
    }

    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" minlength="4">',
            Url::widget()->for(new TypeForm(), 'string')->minlength(4)->render(),
        );
    }

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

    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text">',
            Url::widget()->for(new TypeForm(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]">',
            Url::widget()->for(new TypeForm(), 'string')->render(),
        );
    }

    public function testSize(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" size="20">',
            Url::widget()->for(new TypeForm(), 'string')->size(20)->render(),
        );
    }

    public function testValue(): void
    {
        $formModel = new TypeForm();

        // Value `null`.
        $formModel->setAttribute('string', null);
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]">',
            Url::widget()->for($formModel, 'string')->render(),
        );

        // Value string `'https://yiiframework.com'`
        $formModel->setAttribute('string', 'https://yiiframework.com');
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" value="https://yiiframework.com">',
            Url::widget()->for($formModel, 'string')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Url widget must be a string or null value.');
        Url::widget()->for(new TypeForm(), 'array')->render();
    }
}
