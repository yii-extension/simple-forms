<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Bootstrap5;

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

final class FieldBootstrap5Test extends TestCase
{
    use TestTrait;

    /**
     * @link https://getbootstrap.com/docs/5.0/forms/input-group/
     *
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testAfterInput(): void
    {
        $expected = <<<HTML
        <div class="input-group mb-3">
        <span id="loginform-login" class="input-group-text">@</span>
        <input type="text" id="loginform-login" class="form-control" name="LoginForm[login]" aria-label="Login" aria-describedby="loginHelp" placeholder="Login">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->ariaLabel('Login')
                ->beforeInputHtml(Span::tag()->class('input-group-text')->id('loginform-login')->content('@'))
                ->containerClass('input-group mb-3')
                ->inputClass('form-control')
                ->placeholder('Login')
                ->setAriaDescribedBy(true)
                ->template("{before}\n{input}\n{hint}\n{error}")
                ->text(new LoginForm(), 'login')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/forms/input-group/
     *
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testAfterAndBeforeInput(): void
    {
        $expected = <<<HTML
        <div class="input-group mb-3">
        <span class="input-group-text">.00</span>
        <input type="text" id="typeform-string" class="form-control" name="TypeForm[string]" aria-label="Amount (to the nearest dollar)" aria-describedby="stringHelp">
        <span class="input-group-text">$</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->afterInputHtml(Span::tag()->class('input-group-text')->content('$'))
                ->ariaLabel("Amount (to the nearest dollar)")
                ->beforeInputHtml(Span::tag()->class('input-group-text')->content('.00'))
                ->containerClass('input-group mb-3')
                ->inputClass('form-control')
                ->setAriaDescribedBy(true)
                ->template("{before}\n{input}\n{after}\n{hint}\n{error}")
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/forms/input-group/
     *
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testBeforeInput(): void
    {
        $expected = <<<HTML
        <div class="input-group mb-3">
        <input type="text" id="typeform-string" class="form-control" name="TypeForm[string]" aria-label="Recipient&apos;s username" aria-describedby="stringHelp" placeholder="Recipient&apos;s username">
        <span id="typeform-string" class="input-group-text">@example.com</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->afterInputHtml(Span::tag()->class('input-group-text')->id('typeform-string')->content('@example.com'))
                ->ariaLabel("Recipient's username")
                ->containerClass('input-group mb-3')
                ->inputClass('form-control')
                ->placeholder("Recipient's username")
                ->setAriaDescribedBy(true)
                ->template("{input}\n{after}\n{hint}\n{error}")
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.1/forms/overview/#overview
     *
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testOverview(): void
    {
        $expected = <<<HTML
        <div class="mb-3">
        <label for="loginform-login">Email address</label>
        <input type="text" id="loginform-login" class="form-control" name="LoginForm[login]" aria-describedby="loginHelp">
        <div id="loginHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
        <label for="loginform-password">Password</label>
        <input type="text" id="loginform-password" class="form-control" name="LoginForm[password]">
        </div>
        <input type="submit" id="w1-submit" class="btn btn-primary" name="w1-submit" value="Submit">
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->containerClass('mb-3')
                ->hint("We'll never share your email with anyone else.")
                ->hintClass('form-text')
                ->inputClass('form-control')
                ->label('Email address')
                ->setAriaDescribedBy(true)
                ->text(new LoginForm(), 'login')
                ->render() . PHP_EOL .
            Field::widget()
                ->containerClass('mb-3')
                ->inputClass('form-control')
                ->text(new LoginForm(), 'password') . PHP_EOL .
            Field::widget()
                ->inputClass('btn btn-primary')
                ->submitButton()
                ->value('Submit')
                ->withoutContainer()
        );
    }
}
