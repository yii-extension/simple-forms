<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Field\DefaultValue;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\Form\CustomError;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class FieldInputTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
            Field::widget(['ariaDescribedBy()' => [false]])
                ->defaultValues(['text' => ['ariaDescribedBy' => true]])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
            Field::widget(['attributes()' => [['class' => 'class-definitions']]])
                ->defaultValues(['text' => ['attributes' => ['class' => 'class-widget']]])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
            Field::widget(['containerAttributes()' => [['class' => 'text-left', 'style' => 'color: red']]])
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
            Field::widget(['containerClass()' => ['container-class-definition']])
                ->defaultValues(['text' => ['containerClass' => 'container-class-widget']])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testErrorMessage(): void
    {
        $formModel = new CustomError();
        $formModel->load(['CustomError' => ['login' => '']]);
        $formModel->validateWithAttributes();
        $expected = <<<HTML
        <div>
        <label for="customerror-login">Login</label>
        <input type="text" id="customerror-login" name="CustomError[login]">
        <p class="text-warning invalid-feedback">error-text-widget</p>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testErrorMessageCallback(): void
    {
        $formModel = new CustomError();
        $formModel->load(['CustomError' => ['login' => '']]);
        $formModel->validateWithAttributes();
        $expected = <<<HTML
        <div>
        <label for="customerror-login">Login</label>
        <input type="text" id="customerror-login" name="CustomError[login]">
        <p class="text-warning invalid-feedback">(&amp;#10006;) This is custom error message.</p>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
            Field::widget(
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
            Field::widget(['inputClass()' => ['form-control']])
                ->defaultValues(['text' => ['inputClass' => 'form-control-group']])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testInvalidClass(): void
    {
        $formModel = new CustomError();
        $formModel->load(['CustomError' => ['login' => '']]);
        $formModel->validateWithAttributes();
        $expected = <<<HTML
        <div>
        <label for="customerror-login">Login</label>
        <input type="text" id="customerror-login" class="invalid-tooltip" name="CustomError[login]">
        <div>Value cannot be blank.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['invalidClass()' => ['is-invalid']])
                ->defaultValues(['text' => ['invalidClass' => 'invalid-tooltip']])
                ->text($formModel, 'login')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
            Field::widget(
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
            Field::widget(['placeholder()' => ['placeholder-text']])
                ->defaultValues(['text' => ['placeholder' => 'placeholder-widget-text']])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
            Field::widget(['template()' => ["{input}\n{label}\n{hint}\n{error}"]])
                ->defaultValues(['text' => ['template' => "{label}\n{input}\n{hint}\n{error}"]])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValidClass(): void
    {
        $formModel = new CustomError();
        $formModel->load(['CustomError' => ['login' => 'samdark']]);
        $formModel->validateWithAttributes();
        $expected = <<<HTML
        <div>
        <label for="customerror-login">Login</label>
        <input type="text" id="customerror-login" class="valid-tooltip" name="CustomError[login]" value="samdark">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['validClass()' => ['is-valid']])
                ->defaultValues(['text' => ['validClass' => 'valid-tooltip']])
                ->text($formModel, 'login')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutContainer(): void
    {
        $expected = <<<HTML
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['container()' => [true]])
                ->defaultValues(['text' => ['container' => false]])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }
}
