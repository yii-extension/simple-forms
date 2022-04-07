<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yii\Extension\Form\Url;

final class UrlTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="url" id="propertytype-string" name="PropertyType[string]" autofocus>',
            Url::create()->autofocus()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="url" id="propertytype-string" name="PropertyType[string]" disabled>',
            Url::create()->disabled()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRegex(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorrules-regex" name="ValidatorRules[regex]" pattern="\w+">',
            Url::create()->for(new ValidatorRules(), 'regex')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50">',
            Url::create()->for(new ValidatorRules(), 'maxlength')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15">',
            Url::create()->for(new ValidatorRules(), 'minlength')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorrules-required" name="ValidatorRules[required]" required>',
            Url::create()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeUrlValidator(): void
    {
        $expected = <<<HTML
        <input type="url" id="validatorrules-url" name="ValidatorRules[url]" pattern="^([hH][tT][tT][pP]|[hH][tT][tT][pP][sS]):\/\/(([a-zA-Z0-9][a-zA-Z0-9_-]*)(\.[a-zA-Z0-9][a-zA-Z0-9_-]*)+)(?::\d{1,5})?([?\/#].*$|$)">
        HTML;
        $this->assertSame($expected, Url::create()->for(new ValidatorRules(), 'url')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="url" id="id-test" name="PropertyType[string]">',
            Url::create()->for(new PropertyType(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $url = Url::create();
        $this->assertNotSame($url, $url->maxlength(0));
        $this->assertNotSame($url, $url->minlength(0));
        $this->assertNotSame($url, $url->pattern(''));
        $this->assertNotSame($url, $url->placeholder(''));
        $this->assertNotSame($url, $url->size(0));
    }

    /**
     * @throws ReflectionException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="url" id="propertytype-string" name="PropertyType[string]" maxlength="10">',
            Url::create()->for(new PropertyType(), 'string')->maxlength(10)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="url" id="propertytype-string" name="PropertyType[string]" minlength="4">',
            Url::create()->for(new PropertyType(), 'string')->minlength(4)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="url" id="propertytype-string" name="name-test">',
            Url::create()->for(new PropertyType(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <input type="url" id="propertytype-string" name="PropertyType[string]" pattern="^(http(s)?:\/\/)+[\w\-\._~:\/?#[\]@!$&amp;&apos;\(\)\*\+,;=.]+$">
        HTML;
        $html = Url::create()
            ->for(new PropertyType(), 'string')
            ->pattern("^(http(s)?:\/\/)+[\w\-\._~:\/?#[\]@!\$&'\(\)\*\+,;=.]+$")
            ->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws ReflectionException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="url" id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text">',
            Url::create()->for(new PropertyType(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="url" id="propertytype-string" name="PropertyType[string]" readonly>',
            Url::create()->for(new PropertyType(), 'string')->readOnly()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="url" id="propertytype-string" name="PropertyType[string]" required>',
            Url::create()->for(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="url" id="propertytype-string" name="PropertyType[string]">',
            Url::create()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testSize(): void
    {
        $this->assertSame(
            '<input type="url" id="propertytype-string" name="PropertyType[string]" size="20">',
            Url::create()->for(new PropertyType(), 'string')->size(20)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabIndex(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="url" id="propertytype-string" name="PropertyType[string]" tabindex="1">',
            Url::create()->for(new PropertyType(), 'string')->tabIndex(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value string `https://yiiframework.com`.
        $this->assertSame(
            '<input type="url" id="propertytype-string" name="PropertyType[string]" value="https://yiiframework.com">',
            Url::create()->for(new PropertyType(), 'string')->value('https://yiiframework.com')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="url" id="propertytype-string" name="PropertyType[string]">',
            Url::create()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Url widget must be a string or null value.');
        Url::create()->for(new PropertyType(), 'int')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `https://yiiframework.com`.
        $formModel->setValue('string', 'https://yiiframework.com');
        $this->assertSame(
            '<input type="url" id="propertytype-string" name="PropertyType[string]" value="https://yiiframework.com">',
            Url::create()->for($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->setValue('string', null);
        $this->assertSame(
            '<input type="url" id="propertytype-string" name="PropertyType[string]">',
            Url::create()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="url" name="PropertyType[string]">',
            Url::create()->for(new PropertyType(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="url" id="propertytype-string">',
            Url::create()->for(new PropertyType(), 'string')->name(null)->render(),
        );
    }
}
