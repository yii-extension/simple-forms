<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\LoginForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeWithHintForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Tag\Span;

final class FieldTest extends TestCase
{
    use TestTrait;

    /**
     * @link https://getbootstrap.com/docs/5.0/forms/input-group/
     */
    public function testAfterInput(): void
    {
        $expected = <<<'HTML'
        <div class="input-group mb-3">
        <span id="loginform-login" class="input-group-text">@</span>
        <input type="text" id="loginform-login" class="form-control" name="LoginForm[login]" aria-describedby="loginform-login" aria-label="Login" placeholder="Login">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->ariaDescribedBy()
                ->ariaLabel('Login')
                ->beforeInputHtml(Span::tag()->class('input-group-text')->id('loginform-login')->content('@'))
                ->containerClass('input-group mb-3')
                ->inputClass('form-control')
                ->text(new LoginForm(), 'login')
                ->template("{before}\n{input}\n{hint}\n{error}")
                ->placeholder('Login')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/forms/input-group/
     */
    public function testAfterAndBeforeInput(): void
    {
        $expected = <<<'HTML'
        <div class="input-group mb-3">
        <span class="input-group-text">.00</span>
        <input type="text" id="typeform-string" class="form-control" name="TypeForm[string]" aria-describedby="typeform-string" aria-label="Amount (to the nearest dollar)">
        <span class="input-group-text">$</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->ariaDescribedBy()
                ->ariaLabel("Amount (to the nearest dollar)")
                ->afterInputHtml(Span::tag()->class('input-group-text')->content('$'))
                ->beforeInputHtml(Span::tag()->class('input-group-text')->content('.00'))
                ->containerClass('input-group mb-3')
                ->inputClass('form-control')
                ->text(new TypeForm(), 'string')
                ->template("{before}\n{input}\n{after}\n{hint}\n{error}")
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/forms/input-group/
     */
    public function testBeforeInput(): void
    {
        $expected = <<<'HTML'
        <div class="input-group mb-3">
        <input type="text" id="typeform-string" class="form-control" name="TypeForm[string]" aria-describedby="typeform-string" aria-label="Recipient&apos;s username" placeholder="Recipient&apos;s username">
        <span id="typeform-string" class="input-group-text">@example.com</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->ariaDescribedBy()
                ->ariaLabel("Recipient's username")
                ->afterInputHtml(Span::tag()->class('input-group-text')->id('typeform-string')->content('@example.com'))
                ->containerClass('input-group mb-3')
                ->inputClass('form-control')
                ->text(new TypeForm(), 'string')
                ->template("{input}\n{after}\n{hint}\n{error}")
                ->placeholder("Recipient's username")
                ->render(),
        );
    }

    public function testHintCustom(): void
    {
        $expected = <<<'HTML'
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

    public function testHintCustomWithClassCustom(): void
    {
        $expected = <<<'HTML'
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

    public function testWithoutHint(): void
    {
        $expected = <<<'HTML'
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

    public function testLabelCustom(): void
    {
        $expected = <<<'HTML'
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

    public function testLabelCustomWithLabelClass(): void
    {
        $expected = <<<'HTML'
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

    public function testWithoutLabel(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new TypeForm(), 'string')->withoutLabel()->render(),
        );
    }

    public function testWithoutLabelFor(): void
    {
        $expected = <<<'HTML'
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
