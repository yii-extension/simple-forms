<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Field\DefaultValue;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\Form\CustomError;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class FieldInputTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAriaDescribedBy(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" aria-describedby="propertytype-string-help">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['ariaDescribedBy()' => [false]])
                ->defaultValues(['text' => ['ariaDescribedBy' => true]])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testAttributes(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" class="class-widget" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['attributes()' => [['class' => 'class-definitions']]])
                ->defaultValues(['text' => ['attributes' => ['class' => 'class-widget']]])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testContainerAttributes(): void
    {
        $expected = <<<HTML
        <div class="text-right" style="color: black">
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['containerAttributes()' => [['class' => 'text-left', 'style' => 'color: red']]])
                ->defaultValues(
                    [
                        'text' => [
                            'containerAttributes' => ['class' => 'text-right', 'style' => 'color: black'],
                        ],
                    ],
                )
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testContainerClass(): void
    {
        $expected = <<<HTML
        <div class="container-class-widget">
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['containerClass()' => ['container-class-definition']])
                ->defaultValues(['text' => ['containerClass' => 'container-class-widget']])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testErrorMessage(): void
    {
        $formModel = new CustomError();
        $formModel->load(['CustomError' => ['login' => '']]);
        $formModel->validate();
        $expected = <<<HTML
        <div>
        <label for="customerror-login">Login</label>
        <input type="text" id="customerror-login" name="CustomError[login]">
        <p class="text-warning invalid-feedback">error-text-widget</p>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(
                [
                    'error()' => ['error-text'],
                    'errorAttributes()' => [['class' => 'text-danger']],
                    'errorClass()' => ['is-invalid'],
                    'errorTag()' => ['span'],
                ]
            )
                ->defaultValues(
                    [
                        'text' => [
                            'error' => 'error-text-widget',
                            'errorAttributes' => ['class' => 'text-warning'],
                            'errorClass' => 'invalid-feedback',
                            'errorTag' => 'p',
                        ],
                    ],
                )
                ->text($formModel, 'login')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testErrorMessageCallback(): void
    {
        $formModel = new CustomError();
        $formModel->load(['CustomError' => ['login' => '']]);
        $formModel->validate();
        $expected = <<<HTML
        <div>
        <label for="customerror-login">Login</label>
        <input type="text" id="customerror-login" name="CustomError[login]">
        <p class="text-warning invalid-feedback">(&amp;#10006;) This is custom error message.</p>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(
                [
                    'errorMessageCallback()' => [[$formModel, 'customError']],
                    'errorAttributes()' => [['class' => 'text-danger']],
                    'errorClass()' => ['is-invalid'],
                    'errorTag()' => ['span'],
                ]
            )
                ->defaultValues(
                    [
                        'text' => [
                            'errorMessageCallback' => [$formModel, 'customErrorWithIcon'],
                            'errorAttributes' => ['class' => 'text-warning'],
                            'errorClass' => 'invalid-feedback',
                            'errorTag' => 'p',
                        ],
                    ],
                )
                ->text($formModel, 'login')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testHint(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        <p class="text-warning hint-widget-class">hint-text-widget</p>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(
                [
                    'hint()' => ['hint-text'],
                    'hintAttributes()' => [['class' => 'text-primary']],
                    'hintClass()' => ['hint-class'],
                    'hintTag()' => ['span'],
                ]
            )
                ->defaultValues(
                    [
                        'text' => [
                            'hint' => 'hint-text-widget',
                            'hintAttributes' => ['class' => 'text-warning'],
                            'hintClass' => 'hint-widget-class',
                            'hintTag' => 'p',
                        ],
                    ],
                )
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testInputClass(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" class="form-control-group" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['inputClass()' => ['form-control']])
                ->defaultValues(['text' => ['inputClass' => 'form-control-group']])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testInvalidClass(): void
    {
        $formModel = new CustomError();
        $formModel->load(['CustomError' => ['login' => '']]);
        $formModel->validate();
        $expected = <<<HTML
        <div>
        <label for="customerror-login">Login</label>
        <input type="text" id="customerror-login" class="invalid-tooltip" name="CustomError[login]">
        <div>Value cannot be blank.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['invalidClass()' => ['is-invalid']])
                ->defaultValues(['text' => ['invalidClass' => 'invalid-tooltip']])
                ->text($formModel, 'login')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testLabel(): void
    {
        $expected = <<<HTML
        <div>
        <label class="text-warning label-class-widget" for="propertytype-string">label-text-widget</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(
                [
                    'label()' => ['label-text'],
                    'labelAttributes()' => [['class' => 'text-primary']],
                    'labelClass()' => ['label-class'],
                ]
            )
                ->defaultValues(
                    [
                        'text' => [
                            'label' => 'label-text-widget',
                            'labelAttributes' => ['class' => 'text-warning'],
                            'labelClass' => 'label-class-widget',
                        ],
                    ],
                )
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testPlaceholder(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]" placeholder="placeholder-widget-text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['placeholder()' => ['placeholder-text']])
                ->defaultValues(['text' => ['placeholder' => 'placeholder-widget-text']])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTemplate(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['template()' => ["{input}\n{label}\n{hint}\n{error}"]])
                ->defaultValues(['text' => ['template' => "{label}\n{input}\n{hint}\n{error}"]])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValidClass(): void
    {
        $formModel = new CustomError();
        $formModel->load(['CustomError' => ['login' => 'samdark']]);
        $formModel->validate();
        $expected = <<<HTML
        <div>
        <label for="customerror-login">Login</label>
        <input type="text" id="customerror-login" class="valid-tooltip" name="CustomError[login]" value="samdark">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['validClass()' => ['is-valid']])
                ->defaultValues(['text' => ['validClass' => 'valid-tooltip']])
                ->text($formModel, 'login')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutContainer(): void
    {
        $expected = <<<HTML
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['container()' => [true]])
                ->defaultValues(['text' => ['container' => false]])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }
}
