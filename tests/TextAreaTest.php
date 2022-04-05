<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yii\Extension\Form\TextArea;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class TextAreaTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" autofocus></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->autofocus()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testCols(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" cols="50"></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->cols(50)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDirname(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" dirname="test.dir"></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->dirname('test.dir')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        TextArea::widget()->for(new PropertyType(), 'string')->dirname('')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" disabled></textarea>',
            TextArea::widget()->disabled()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<textarea id="validatorrules-maxlength" name="ValidatorRules[maxlength]" maxlength="50"></textarea>',
            TextArea::widget()->for(new ValidatorRules(), 'maxlength')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<textarea id="validatorrules-minlength" name="ValidatorRules[minlength]" minlength="15"></textarea>',
            TextArea::widget()->for(new ValidatorRules(), 'minlength')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<textarea id="validatorrules-required" name="ValidatorRules[required]" required></textarea>',
            TextArea::widget()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $textArea = TextArea::widget();
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" maxlength="100"></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->maxLength(100)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" minlength="20"></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->minLength(20)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="name-test"></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" placeholder="PlaceHolder Text"></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" readonly></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->readOnly()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" required></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]"></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRows(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" rows="4"></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->rows(4)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `hello`.
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]">hello</textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->value('hello')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]"></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('TextArea widget must be a string or null value.');
        TextArea::widget()->for(new PropertyType(), 'array')->render();
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
            '<textarea id="propertytype-string" name="PropertyType[string]">hello</textarea>',
            TextArea::widget()->for($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->setValue('string', null);
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]"></textarea>',
            TextArea::widget()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWrap(): void
    {
        /** hard value */
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" wrap="hard"></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->wrap()->render(),
        );

        /** soft value */
        $this->assertSame(
            '<textarea id="propertytype-string" name="PropertyType[string]" wrap="soft"></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->wrap('soft')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWrapException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid wrap value. Valid values are: hard, soft.');
        TextArea::widget()->for(new PropertyType(), 'string')->wrap('exception');
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<textarea name="PropertyType[string]"></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<textarea id="propertytype-string"></textarea>',
            TextArea::widget()->for(new PropertyType(), 'string')->name(null)->render(),
        );
    }
}
