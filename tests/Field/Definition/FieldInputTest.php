<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Field\Definition;

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
    public function testAriaDescribed(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['ariaDescribedBy()' => [false]])->text(new PropertyType(), 'string')->render(),
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
        <input type="text" id="propertytype-string" class="class-definitions" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['attributes()' => [['class' => 'class-definitions']]])
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
        <div class="text-left" style="color: red">
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['containerAttributes()' => [['class' => 'text-left', 'style' => 'color: red']]])
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
        <div class="container-class-definition">
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['containerClass()' => ['container-class-definition']])
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
        $formModel->validate();
        $expected = <<<HTML
        <div>
        <label for="customerror-login">Login</label>
        <input type="text" id="customerror-login" name="CustomError[login]">
        <span class="text-danger is-invalid">error-text</span>
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
        $formModel->validate();
        $expected = <<<HTML
        <div>
        <label for="customerror-login">Login</label>
        <input type="text" id="customerror-login" name="CustomError[login]">
        <span class="text-danger is-invalid">This is custom error message.</span>
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
        <span class="text-primary hint-class">hint-text</span>
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
        <input type="text" id="propertytype-string" class="form-control" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['inputClass()' => ['form-control']])->text(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testInvalidClass(): void
    {
        $formModel = new CustomError();
        $formModel->load(['CustomError' => ['login' => '']]);
        $formModel->validate();
        $expected = <<<HTML
        <div>
        <label for="customerror-login">Login</label>
        <input type="text" id="customerror-login" class="is-invalid" name="CustomError[login]">
        <div>Value cannot be blank.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['invalidClass()' => ['is-invalid']])->text($formModel, 'login')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLabel(): void
    {
        $expected = <<<HTML
        <div>
        <label class="text-primary label-class" for="propertytype-string">label-text</label>
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
        <input type="text" id="propertytype-string" name="PropertyType[string]" placeholder="placeholder-text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['placeholder()' => ['placeholder-text']])->text(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTemplate(): void
    {
        $expected = <<<HTML
        <div>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        <label for="propertytype-string">String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['template()' => ["{input}\n{label}\n{hint}\n{error}"]])
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
        $formModel->validate();
        $expected = <<<HTML
        <div>
        <label for="customerror-login">Login</label>
        <input type="text" id="customerror-login" class="is-valid" name="CustomError[login]" value="samdark">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['validClass()' => ['is-valid']])->text($formModel, 'login')->render(),
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
            Field::create(['container()' => [false]])->text(new PropertyType(), 'string')->render(),
        );
    }
}
