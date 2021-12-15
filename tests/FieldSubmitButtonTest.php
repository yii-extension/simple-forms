<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Html;

final class FieldSubmitButtonTest extends TestCase
{
    use TestTrait;

    public function testAutofocus(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->submitButton()->autofocus()->render());
    }

    public function testDisabled(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->submitButton()->disabled()->render());
    }

    public function testId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="test-id" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->submitButton()->id('test-id')->render());
    }

    public function testName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="test-name">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->submitButton()->name('test-name')->render());
    }

    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->submitButton()->render());
    }

    public function testTabIndex(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->submitButton()->tabIndex(1)->render());
    }

    public function testValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" value="Save">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->submitButton()->value('Save')->render());
    }

    public function testWithoutId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->submitButton()->id(null)->render(),
        );
    }

    public function testWithoutName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->submitButton()->name(null)->render(),
        );
    }
}
