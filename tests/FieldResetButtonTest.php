<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Html;

final class FieldResetButtonTest extends TestCase
{
    use TestTrait;

    public function testAutofocus(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="reset" id="w1-reset" name="w1-reset" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->resetButton()->autofocus()->render());
    }

    public function testDisabled(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="reset" id="w1-reset" name="w1-reset" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->resetButton()->disabled()->render());
    }

    public function testId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="reset" id="id-test" name="w1-reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->resetButton()->id('id-test')->render());
    }

    public function testName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="reset" id="w1-reset" name="name-test">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->resetButton()->name('name-test')->render());
    }

    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="reset" id="w1-reset" name="w1-reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->resetButton()->render());
    }

    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <div>
        <input type="reset" id="w2-reset" name="w2-reset" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->resetButton()->tabIndex(1)->render());
    }

    public function testValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="reset" id="w1-reset" name="w1-reset" value="Reseteable">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->resetButton()->value('Reseteable')->render());
    }

    public function testWithoutId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="reset" name="w1-reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->resetButton()->id(null)->render(),
        );
    }

    public function testWithoutName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="reset" id="w1-reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->resetButton()->name(null)->render(),
        );
    }
}
