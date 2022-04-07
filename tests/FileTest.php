<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\File;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\Form\ValidatorRules;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class FileTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAccept(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]" accept="image/*">',
            File::create()->for(new PropertyType(), 'array')->accept('image/*')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]" autofocus>',
            File::create()->for(new PropertyType(), 'array')->autofocus()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]" disabled>',
            File::create()->for(new PropertyType(), 'array')->disabled()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="file" id="validatorrules-required" name="ValidatorRules[required][]" required>',
            File::create()->for(new ValidatorRules(), 'required')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testHiddenAttributes(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" id="test-id" name="PropertyType[array]" value="0"><input type="file" id="propertytype-array" name="PropertyType[array][]">
        HTML;
        $html = File::create()
            ->for(new PropertyType(), 'array')
            ->hiddenAttributes(['id' => 'test-id'])
            ->uncheckValue('0')
            ->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="file" id="id-test" name="PropertyType[array][]">',
            File::create()->for(new PropertyType(), 'array')->id('id-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $fileInput = File::create();
        $this->assertNotSame($fileInput, $fileInput->accept(''));
        $this->assertNotSame($fileInput, $fileInput->hiddenAttributes([]));
        $this->assertNotSame($fileInput, $fileInput->multiple());
        $this->assertNotSame($fileInput, $fileInput->uncheckValue(true));
    }

    /**
     * @throws ReflectionException
     */
    public function testMultiple(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]" multiple>',
            File::create()->for(new PropertyType(), 'array')->multiple()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="name-test[]">',
            File::create()->for(new PropertyType(), 'array')->name('name-test')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]" required>',
            File::create()->for(new PropertyType(), 'array')->required()->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]">',
            File::create()->for(new PropertyType(), 'array')->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabIndex(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]" tabindex="1">',
            File::create()->for(new PropertyType(), 'array')->tabIndex(1)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" name="PropertyType[array]" value="0"><input type="file" id="propertytype-array" name="PropertyType[array][]">
        HTML;
        $html = File::create()->for(new PropertyType(), 'array')->uncheckValue('0')->render();
        $this->assertSame($expected, $html);

        $expected = <<<'HTML'
        <input type="hidden" name="PropertyType[array]" value="1"><input type="file" id="propertytype-array" name="PropertyType[array][]">
        HTML;
        $html = File::create()->for(new PropertyType(), 'array')->uncheckValue(true)->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="file" name="PropertyType[array][]">',
            File::create()->for(new PropertyType(), 'array')->id(null)->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="file" id="propertytype-array" name="PropertyType[array][]">',
            File::create()->for(new PropertyType(), 'array')->name(null)->render(),
        );
    }
}
