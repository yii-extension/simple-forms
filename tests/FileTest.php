<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\File;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class FileTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAccept(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]" accept="image/*">',
            File::widget()->for(new PropertyType(), 'array')->accept('image/*')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]" autofocus>',
            File::widget()->for(new PropertyType(), 'array')->autofocus()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]" disabled>',
            File::widget()->for(new PropertyType(), 'array')->disabled()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="file" id="validatorrules-required" name="ValidatorRules[required][]" required>',
            File::widget()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testHiddenAttributes(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" id="test-id" name="PropertyType[array]" value="0"><input type="file" id="propertytype-array" name="PropertyType[array][]">
        HTML;
        $html = File::widget()
            ->for(new PropertyType(), 'array')
            ->hiddenAttributes(['id' => 'test-id'])
            ->uncheckValue('0')
            ->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="file" id="id-test" name="PropertyType[array][]">',
            File::widget()->for(new PropertyType(), 'array')->id('id-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $fileInput = File::widget();
        $this->assertNotSame($fileInput, $fileInput->accept(''));
        $this->assertNotSame($fileInput, $fileInput->hiddenAttributes([]));
        $this->assertNotSame($fileInput, $fileInput->multiple());
        $this->assertNotSame($fileInput, $fileInput->uncheckValue(true));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMultiple(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]" multiple>',
            File::widget()->for(new PropertyType(), 'array')->multiple()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="name-test[]">',
            File::widget()->for(new PropertyType(), 'array')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]" required>',
            File::widget()->for(new PropertyType(), 'array')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]">',
            File::widget()->for(new PropertyType(), 'array')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]" tabindex="1">',
            File::widget()->for(new PropertyType(), 'array')->tabIndex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" name="PropertyType[array]" value="0"><input type="file" id="propertytype-array" name="PropertyType[array][]">
        HTML;
        $html = File::widget()->for(new PropertyType(), 'array')->uncheckValue('0')->render();
        $this->assertSame($expected, $html);

        $expected = <<<'HTML'
        <input type="hidden" name="PropertyType[array]" value="1"><input type="file" id="propertytype-array" name="PropertyType[array][]">
        HTML;
        $html = File::widget()->for(new PropertyType(), 'array')->uncheckValue(true)->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="file" name="PropertyType[array][]">',
            File::widget()->for(new PropertyType(), 'array')->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]">',
            File::widget()->for(new PropertyType(), 'array')->name(null)->render(),
        );
    }
}
