<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yii\Extension\Form\Text;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class TextTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]" autofocus>',
            Text::create()->autofocus()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDirname(): void
    {
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]" dirname="test.dir">',
            Text::create()->for(new PropertyType(), 'string')->dirname('test.dir')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        Text::create()->for(new PropertyType(), 'string')->dirname('')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]" disabled>',
            Text::create()->disabled()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRegex(): void
    {
        $this->assertSame(
            '<input type="text" id="validatorrules-regex" name="ValidatorRules[regex]" pattern="\w+">',
            Text::create()->for(new ValidatorRules(), 'regex')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="text" id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50">',
            Text::create()->for(new ValidatorRules(), 'maxlength')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="text" id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15">',
            Text::create()->for(new ValidatorRules(), 'minlength')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="text" id="validatorrules-required" name="ValidatorRules[required]" required>',
            Text::create()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="text" id="id-test" name="PropertyType[string]">',
            Text::create()->for(new PropertyType(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $text = Text::create();
        $this->assertNotSame($text, $text->dirname('test.dir'));
        $this->assertNotSame($text, $text->maxlength(0));
        $this->assertNotSame($text, $text->minlength(0));
        $this->assertNotSame($text, $text->placeholder(''));
        $this->assertNotSame($text, $text->pattern(''));
        $this->assertNotSame($text, $text->readOnly());
        $this->assertNotSame($text, $text->size(0));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]" maxlength="10">',
            Text::create()->for(new PropertyType(), 'string')->maxlength(10)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]" minlength="4">',
            Text::create()->for(new PropertyType(), 'string')->minlength(4)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="name-test">',
            Text::create()->for(new PropertyType(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <input type="text" id="propertytype-string" name="PropertyType[string]" title="Only accepts uppercase and lowercase letters." pattern="[A-Za-z]">
        HTML;
        $html = Text::create()
            ->for(new PropertyType(), 'string')
            ->pattern('[A-Za-z]')
            ->title('Only accepts uppercase and lowercase letters.')
            ->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text">',
            Text::create()->for(new PropertyType(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]" readonly>',
            Text::create()->for(new PropertyType(), 'string')->readOnly()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]" required>',
            Text::create()->for(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]">',
            Text::create()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSize(): void
    {
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]" size="10">',
            Text::create()->for(new PropertyType(), 'string')->size(10)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]" tabindex="1">',
            Text::create()->for(new PropertyType(), 'string')->tabIndex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `hello`.
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]" value="hello">',
            Text::create()->for(new PropertyType(), 'string')->value('hello')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]">',
            Text::create()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Text widget must be a string or null value.');
        Text::create()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `hello`.
        $formModel->setValue('string', 'hello');
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]" value="hello">',
            Text::create()->for($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->setValue('string', null);
        $this->assertSame(
            '<input type="text" id="propertytype-string" name="PropertyType[string]">',
            Text::create()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="text" name="PropertyType[string]">',
            Text::create()->for(new PropertyType(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="text" id="propertytype-string">',
            Text::create()->for(new PropertyType(), 'string')->name(null)->render(),
        );
    }
}
