<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yii\Extension\Form\TextArea;

final class TextAreaTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" autofocus></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->autofocus()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testCols(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" cols="50"></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->cols(50)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDirname(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" dirname="test.dir"></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->dirname('test.dir')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        TextArea::create()->for(new PropertyType(), 'string')->dirname('')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" disabled></textarea>',
            TextArea::create()->disabled()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<textarea id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50"></textarea>',
            TextArea::create()->for(new ValidatorRules(), 'maxlength')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<textarea id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15"></textarea>',
            TextArea::create()->for(new ValidatorRules(), 'minlength')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<textarea id="validatorrules-required" name="ValidatorRules[required]" required></textarea>',
            TextArea::create()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $textArea = TextArea::create();
        $this->assertNotSame($textArea, $textArea->cols(0));
        $this->assertNotSame($textArea, $textArea->dirname('test.dir'));
        $this->assertNotSame($textArea, $textArea->maxlength(0));
        $this->assertNotSame($textArea, $textArea->minlength(0));
        $this->assertNotSame($textArea, $textArea->placeholder(''));
        $this->assertNotSame($textArea, $textArea->readOnly());
        $this->assertNotSame($textArea, $textArea->rows(0));
        $this->assertNotSame($textArea, $textArea->wrap('hard'));
    }

    /**
     * @throws ReflectionException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" maxlength="100"></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->maxLength(100)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" minlength="20"></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->minLength(20)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="name-test"></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text"></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" readonly></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->readOnly()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" required></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]"></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRows(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" rows="4"></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->rows(4)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        // Value string `hello`.
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]">hello</textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->value('hello')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]"></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('TextArea widget must be a string or null value.');
        TextArea::create()->for(new PropertyType(), 'array')->render();
    }

    /**
     * @throws ReflectionException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new PropertyType();

        // Value string `hello`.
        $formModel->setValue('string', 'hello');
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]">hello</textarea>',
            TextArea::create()->for($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->setValue('string', null);
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]"></textarea>',
            TextArea::create()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWrap(): void
    {
        /** hard value */
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" wrap="hard"></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->wrap()->render(),
        );

        /** soft value */
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" wrap="soft"></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->wrap('soft')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWrapException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid wrap value. Valid values are: hard, soft.');
        TextArea::create()->for(new PropertyType(), 'string')->wrap('exception');
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<textarea name="PropertyType[string]"></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string"></textarea>',
            TextArea::create()->for(new PropertyType(), 'string')->name(null)->render(),
        );
    }
}
