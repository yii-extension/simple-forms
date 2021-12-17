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
use Yiisoft\Html\Tag\Span;

final class FieldTest extends TestCase
{
    use TestTrait;

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testHintCustom(): void
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
            Field::widget()->text(new TypeForm(), 'string')->hint('Custom hint')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testHintCustomWithClassCustom(): void
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
            Field::widget()->text(new TypeForm(), 'string')->hint('Custom hint')->hintClass('text-success')->render(),
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
    public function testLabelCustom(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">Custom label</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new TypeForm(), 'string')->label('Custom label')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testLabelCustomWithLabelClass(): void
    {
        $expected = <<<HTML
        <div>
        <label class="required" for="typeform-string">Custom label</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new TypeForm(), 'string')->label('Custom label')->labelClass('required')->render(),
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
