<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\LoginForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeWithHintForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Span;

final class FieldTest extends TestCase
{
    use TestTrait;

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testAttributes(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->attributes(['required' => true])->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testButtonsIndividualAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" value="Submit"><input type="reset" id="w2-reset" name="w2-reset" value="Reseteable">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->buttonsIndividualAttributes(['0' => ['value' => 'Submit'], '1' => ['value' => 'Reseteable'],])
                ->submitButton()
                ->resetButton()
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testContainerAttributes(): void
    {
        $expected = <<<HTML
        <div class="text-danger">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->containerAttributes(['class' => 'text-danger'])->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testContainerId(): void
    {
        $expected = <<<HTML
        <div id="id-test">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->containerId('id-test')->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testContainerName(): void
    {
        $expected = <<<HTML
        <div name="name-test">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->containerName('name-test')->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testHintAttributes(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        <div class="help-block">Custom hint</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->hint('Custom hint')
                ->hintAttributes(['class' => 'help-block'])
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testHint(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        <div>Custom hint</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->hint('Custom hint')->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testHintTag(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        <span>Custom hint</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->hint('Custom hint')->hintTag('span')->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testHintWithClass(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        <div class="text-success">Custom hint</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->hint('Custom hint')->hintClass('text-success')->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testLabel(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">Custom label</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->label('Custom label')->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testLabelFor(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->labelFor('id-test')->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testLabelWithLabelClass(): void
    {
        $expected = <<<HTML
        <div>
        <label class="required" for="typeform-string">Custom label</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->label('Custom label')->labelClass('required')->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutContainer(): void
    {
        $expected = <<<HTML
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new TypeForm(), 'string')->withoutContainer()->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutHint(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typewithhintform-login">Login</label>
        <input type="text" id="typewithhintform-login" name="TypeWithHintForm[login]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new TypeWithHintForm(), 'login')->withoutHint()->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutLabel(): void
    {
        $expected = <<<HTML
        <div>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new TypeForm(), 'string')->withoutLabel()->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutLabelFor(): void
    {
        $expected = <<<HTML
        <div>
        <label>String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new TypeForm(), 'string')->WithoutLabelFor()->render(),
        );
    }
}
