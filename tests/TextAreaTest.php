<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\ValidatorForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yii\Extension\Simple\Forms\TextArea;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class TextAreaTest extends TestCase
{
    use TestTrait;

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" autofocus></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->autofocus()->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testCols(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" cols="50"></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->cols(50)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDirname(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" dirname="test.dir"></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->dirname('test.dir')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        TextArea::widget()->for(new TypeForm(), 'string')->dirname('')->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" disabled></textarea>',
            TextArea::widget()->disabled()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<textarea id="validatorform-maxlength" name="ValidatorForm[maxlength]" maxlength="50"></textarea>',
            TextArea::widget()->for(new ValidatorForm(), 'maxlength')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<textarea id="validatorform-minlength" name="ValidatorForm[minlength]" minlength="15"></textarea>',
            TextArea::widget()->for(new ValidatorForm(), 'minlength')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testImmutability(): void
    {
        $textArea = TextArea::widget();
        $this->assertNotSame($textArea, $textArea->cols(0));
        $this->assertNotSame($textArea, $textArea->dirname('test.dir'));
        $this->assertNotSame($textArea, $textArea->maxlength(0));
        $this->assertNotSame($textArea, $textArea->placeholder(''));
        $this->assertNotSame($textArea, $textArea->readOnly());
        $this->assertNotSame($textArea, $textArea->rows(0));
        $this->assertNotSame($textArea, $textArea->wrap('hard'));
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" maxlength="100"></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->maxLength(100)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" minlength="20"></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->minLength(20)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="name-test"></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text"></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testReadOnly(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" readonly></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->readOnly()->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" required></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->required()->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]"></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRows(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" rows="4"></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->rows(4)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValue(): void
    {
        // Value `null`.
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]"></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->value(null)->render(),
        );

        // Value string `hello`.
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]">hello</textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->value('hello')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('TextArea widget must be a string or null value.');
        TextArea::widget()->for(new TypeForm(), 'array')->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value `null`.
        $formModel->setAttribute('string', null);
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]"></textarea>',
            TextArea::widget()->for($formModel, 'string')->render(),
        );

        // Value string `hello`.
        $formModel->setAttribute('string', 'hello');
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]">hello</textarea>',
            TextArea::widget()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWrap(): void
    {
        /** hard value */
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" wrap="hard"></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->wrap()->render(),
        );

        /** soft value */
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" wrap="soft"></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->wrap('soft')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWrapException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid wrap value. Valid values are: hard, soft.');
        TextArea::widget()->for(new TypeForm(), 'string')->wrap('exception');
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<textarea name="TypeForm[string]"></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string"></textarea>',
            TextArea::widget()->for(new TypeForm(), 'string')->name(null)->render(),
        );
    }
}
