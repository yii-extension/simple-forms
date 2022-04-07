<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Attribute;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class FieldAttributeTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $field = Field::create();
        $this->assertNotSame($field, $field->ariaDescribedBy(true));
        $this->assertNotSame($field, $field->ariaLabel(''));
        $this->assertNotSame($field, $field->container(true));
        $this->assertNotSame($field, $field->containerAttributes([]));
        $this->assertNotSame($field, $field->containerClass(''));
        $this->assertNotSame($field, $field->containerId(null));
        $this->assertNotSame($field, $field->containerName(null));
        $this->assertNotSame($field, $field->defaultTokens([]));
        $this->assertNotSame($field, $field->defaultValues([]));
        $this->assertNotSame($field, $field->error(null));
        $this->assertNotSame($field, $field->errorAttributes([]));
        $this->assertNotSame($field, $field->errorClass(''));
        $this->assertNotSame($field, $field->errorMessageCallback([]));
        $this->assertNotSame($field, $field->errorTag(''));
        $this->assertNotSame($field, $field->hint(null));
        $this->assertNotSame($field, $field->hintAttributes([]));
        $this->assertNotSame($field, $field->hintClass(''));
        $this->assertNotSame($field, $field->hintTag(''));
        $this->assertNotSame($field, $field->inputClass(''));
        $this->assertNotSame($field, $field->invalidClass(''));
        $this->assertNotSame($field, $field->label(null));
        $this->assertNotSame($field, $field->labelAttributes([]));
        $this->assertNotSame($field, $field->labelClass(''));
        $this->assertNotSame($field, $field->labelFor(null));
        $this->assertNotSame($field, $field->placeholder(''));
        $this->assertNotSame($field, $field->readonly(true));
        $this->assertNotSame($field, $field->replaceIndividualToken('', ''));
        $this->assertNotSame($field, $field->required());
        $this->assertNotSame($field, $field->template(''));
        $this->assertNotSame($field, $field->validClass(''));
        $this->assertNotSame($field, $this->invokeMethod($field, 'type', ['']));
    }
}
