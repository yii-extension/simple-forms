<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\CformBuilder;
use Yii\Extension\Simple\Forms\Password;
use Yii\Extension\Simple\Forms\ResetButton;
use Yii\Extension\Simple\Forms\SubmitButton;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\LoginForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeWithHintForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yii\Extension\Simple\Forms\Text;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Span;

final class CformBuilderTest extends TestCase
{
    use TestTrait;

    public function testComplexForm(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expectec = <<<HTML
        <form id="w1-form" method="POST">
        <span>Im flexible</span>
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]">
        </div>
        <span>Im flexible</span>
        <div class="input-group">
        <button class="btn border" @click="showPassword = !showPassword">
        <i class="eye" v-if="showPassword"></i>
        <i class="eye-slash" v-else="true"></i>
        </button>
        <input type="password" id="loginform-password" name="LoginForm[password]">
        </div>
        <span>Im flexible</span>
        </form>
        HTML;
        $this->assertEqualsWithoutLE(
            $expectec,
            CformBuilder::widget()
                ->addFields(
                    Span::tag()->content('Im flexible'),
                    Text::widget()->for(new LoginForm(), 'login'),
                    Span::tag()->content('Im flexible'),
                    Password::widget()->for(new LoginForm(), 'password'),
                    Span::tag()->content('Im flexible'),
                )
                ->individualContainerClass(['password' => 'input-group'])
                ->individualInputHtml(
                    [
                        'password' => Button::tag()
                            ->attributes(["@click" => "showPassword = !showPassword"])
                            ->class('btn border')
                            ->content(
                                PHP_EOL .
                                Html::tag('i', '', ['class' => 'eye', 'v-if' => 'showPassword']) . PHP_EOL .
                                Html::tag('i', '', ['class' => 'eye-slash', 'v-else' => 'true']) . PHP_EOL
                            )
                            ->encode(false)
                            ->render(),
                    ]
                )
                ->individualTemplateField(
                    ['password' => "{inputHtml}\n{input}\n{hint}\n{error}"],
                )
                ->render(),
        );
    }

    public function testIndividualHintClass(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expectec = <<<HTML
        <form id="w1-form" method="POST">
        <div>
        <label for="typewithhintform-login">Login</label>
        <input type="text" id="typewithhintform-login" name="TypeWithHintForm[login]">
        <div class="test-class-1">Please enter your login.</div>
        </div>
        <div>
        <label for="typewithhintform-password">Password</label>
        <input type="password" id="typewithhintform-password" name="TypeWithHintForm[password]">
        <div class="test-class-2">Please enter your password.</div>
        </div>
        </form>
        HTML;
        $this->assertEqualsWithoutLE(
            $expectec,
            CformBuilder::widget()
                ->addFields(
                    Text::widget()->for(new TypeWithHintForm(), 'login'),
                    Password::widget()->for(new TypeWithHintForm(), 'password'),
                )
                ->individualHintClass(['login' => 'test-class-1', 'password' => 'test-class-2'])
                ->render(),
        );
    }

    public function testIndividualInputClass(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expectec = <<<HTML
        <form id="w1-form" method="POST">
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" class="test-class-1" name="LoginForm[login]">
        </div>
        <div>
        <label for="loginform-password">Password</label>
        <input type="password" id="loginform-password" class="test-class-2" name="LoginForm[password]">
        </div>
        </form>
        HTML;
        $this->assertEqualsWithoutLE(
            $expectec,
            CformBuilder::widget()
                ->addFields(
                    Text::widget()->for(new LoginForm(), 'login'),
                    Password::widget()->for(new LoginForm(), 'password'),
                )
                ->individualInputClass(['login' => 'test-class-1', 'password' => 'test-class-2'])
                ->render(),
        );
    }

    public function testIndividualLabelClass(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expectec = <<<HTML
        <form id="w1-form" method="POST">
        <div>
        <label class="test-class-1" for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]">
        </div>
        <div>
        <label class="test-class-2" for="loginform-password">Password</label>
        <input type="password" id="loginform-password" name="LoginForm[password]">
        </div>
        </form>
        HTML;
        $this->assertEqualsWithoutLE(
            $expectec,
            CformBuilder::widget()
                ->addFields(
                    Text::widget()->for(new LoginForm(), 'login'),
                    Password::widget()->for(new LoginForm(), 'password'),
                )
                ->individualLabelClass(['login' => 'test-class-1', 'password' => 'test-class-2'])
                ->render(),
        );
    }

    public function testIndividualLabelText(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        // Remove label tag attribute login.
        $expectec = <<<HTML
        <form id="w1-form" method="POST">
        <div>
        <input type="text" id="loginform-login" name="LoginForm[login]">
        </div>
        <div>
        <label for="loginform-password">Password</label>
        <input type="password" id="loginform-password" name="LoginForm[password]">
        </div>
        </form>
        HTML;
        $this->assertEqualsWithoutLE(
            $expectec,
            CformBuilder::widget()
                ->addFields(
                    Text::widget()->for(new LoginForm(), 'login'),
                    Password::widget()->for(new LoginForm(), 'password'),
                )
                ->individualLabelText(['login' => null])
                ->render(),
        );

        // Set custom label text for attribute.
        $expectec = <<<HTML
        <form id="w2-form" method="POST">
        <div>
        <label for="loginform-login">Login:</label>
        <input type="text" id="loginform-login" name="LoginForm[login]">
        </div>
        <div>
        <label for="loginform-password">Password:</label>
        <input type="password" id="loginform-password" name="LoginForm[password]">
        </div>
        </form>
        HTML;
        $this->assertEqualsWithoutLE(
            $expectec,
            CformBuilder::widget()
                ->addFields(
                    Text::widget()->for(new LoginForm(), 'login'),
                    Password::widget()->for(new LoginForm(), 'password'),
                )
                ->individualLabelText(['login' => 'Login:', 'password' => 'Password:'])
                ->render(),
        );
    }

    public function testIndividualTemplateField(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expectec = <<<HTML
        <form id="w1-form" method="POST">
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]">
        </div>
        <div>
        <input type="password" id="loginform-password" name="LoginForm[password]">
        <label for="loginform-password">Password</label>
        </div>
        </form>
        HTML;
        $this->assertEqualsWithoutLE(
            $expectec,
            CformBuilder::widget()
                ->addFields(
                    Text::widget()->for(new LoginForm(), 'login'),
                    Password::widget()->for(new LoginForm(), 'password'),
                )
                ->individualTemplateField(
                    ['login' => "{label}\n{input}\n{hint}\n{error}", 'password' => "{input}\n{label}\n{hint}\n{error}"],
                )
                ->render(),
        );
    }

    public function testHintClass(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expectec = <<<HTML
        <form id="w1-form" method="POST">
        <div>
        <label for="typewithhintform-login">Login</label>
        <input type="text" id="typewithhintform-login" name="TypeWithHintForm[login]">
        <div class="help-block">Please enter your login.</div>
        </div>
        <div>
        <label for="typewithhintform-password">Password</label>
        <input type="password" id="typewithhintform-password" name="TypeWithHintForm[password]">
        <div class="help-block">Please enter your password.</div>
        </div>
        </form>
        HTML;
        $this->assertEqualsWithoutLE(
            $expectec,
            CformBuilder::widget()
                ->addFields(
                    Text::widget()->for(new TypeWithHintForm(), 'login'),
                    Password::widget()->for(new TypeWithHintForm(), 'password'),
                )
                ->hintClass('help-block')
                ->render(),
        );
    }

    public function testInputClass(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expectec = <<<HTML
        <form id="w1-form" method="POST">
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" class="form-control" name="LoginForm[login]">
        </div>
        <div>
        <label for="loginform-password">Password</label>
        <input type="password" id="loginform-password" class="form-control" name="LoginForm[password]">
        </div>
        </form>
        HTML;
        $this->assertEqualsWithoutLE(
            $expectec,
            CformBuilder::widget()
                ->addFields(
                    Text::widget()->for(new LoginForm(), 'login'),
                    Password::widget()->for(new LoginForm(), 'password'),
                )
                ->inputClass('form-control')
                ->render(),
        );
    }

    public function testLabelClass(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expectec = <<<HTML
        <form id="w1-form" method="POST">
        <div>
        <label class="form-label" for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]">
        </div>
        <div>
        <label class="form-label" for="loginform-password">Password</label>
        <input type="password" id="loginform-password" name="LoginForm[password]">
        </div>
        </form>
        HTML;
        $this->assertEqualsWithoutLE(
            $expectec,
            CformBuilder::widget()
                ->addFields(
                    Text::widget()->for(new LoginForm(), 'login'),
                    Password::widget()->for(new LoginForm(), 'password'),
                )
                ->labelClass('form-label')
                ->render(),
        );
    }

    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame('<form id="w1-form" method="POST"></form>', CformBuilder::widget()->render());
    }

    public function testTemplateField(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expectec = <<<HTML
        <form id="w1-form" method="POST">
        <div>
        <input type="text" id="loginform-login" name="LoginForm[login]">
        <label for="loginform-login">Login</label>
        </div>
        <div>
        <input type="password" id="loginform-password" name="LoginForm[password]">
        <label for="loginform-password">Password</label>
        </div>
        </form>
        HTML;
        $this->assertEqualsWithoutLE(
            $expectec,
            CformBuilder::widget()
                ->addFields(
                    Text::widget()->for(new LoginForm(), 'login'),
                    Password::widget()->for(new LoginForm(), 'password'),
                )
                ->templateField("{input}\n{label}\n{hint}\n{error}")
                ->render(),
        );
    }

    public function testTemplateForm(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        // Set template buttons to first form.
        $expectec = <<<HTML
        <form id="w1-form" method="POST">
        <div>
        <input type="reset" id="w2-reset" class="btn btn-danger btn-lg" name="w2-reset" value="Reset">
        <input type="submit" id="w3-submit" class="btn btn-danger btn-lg" name="w3-submit" value="Submit">
        </div>
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]">
        </div>
        </form>
        HTML;
        $this->assertEqualsWithoutLE(
            $expectec,
            CformBuilder::widget()
                ->addButtons(
                    ResetButton::widget()->attributes(['class' => 'btn btn-danger btn-lg'])->value('Reset'),
                    SubmitButton::widget()->attributes(['class' => 'btn btn-danger btn-lg'])->value('Submit'),
                )
                ->addFields(
                    Text::widget()->for(new LoginForm(), 'login'),
                )
                ->templateForm("{buttons}\n{form}")
                ->render(),
        );

        // Set template buttons to last form.
        $expectec = <<<HTML
        <form id="w4-form" method="POST">
        <div>
        <label for="loginform-login">Login</label>
        <input type="text" id="loginform-login" name="LoginForm[login]">
        </div>
        <div>
        <input type="reset" id="w5-reset" class="btn btn-danger btn-lg" name="w5-reset" value="Reset">
        <input type="submit" id="w6-submit" class="btn btn-danger btn-lg" name="w6-submit" value="Submit">
        </div>
        </form>
        HTML;
        $this->assertEqualsWithoutLE(
            $expectec,
            CformBuilder::widget()
                ->addButtons(
                    ResetButton::widget()->attributes(['class' => 'btn btn-danger btn-lg'])->value('Reset'),
                    SubmitButton::widget()->attributes(['class' => 'btn btn-danger btn-lg'])->value('Submit'),
                )
                ->addFields(
                    Text::widget()->for(new LoginForm(), 'login'),
                )
                ->templateForm("{form}\n{buttons}")
                ->render(),
        );
    }
}

