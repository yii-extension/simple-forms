<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Html;

final class FieldResetButtonTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="reset" id="w1-reset" name="w1-reset" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->autofocus()->resetButton()->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="reset" id="w1-reset" name="w1-reset" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->disabled()->resetButton()->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testForm(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="reset" id="w1-reset" name="w1-reset" form="form-register">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->resetButton(['form()' => ['form-register']])->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="reset" id="test-id" name="w1-reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->id('test-id')->resetButton()->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="reset" id="w1-reset" name="test-name">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->name('test-name')->resetButton()->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="reset" id="w1-reset" name="w1-reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->resetButton()->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testTabindex(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->submitButton()->tabindex(1)->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="reset" id="w1-reset" name="w1-reset" value="Reseteable">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->resetButton()->value('Reseteable')->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="reset" name="w1-reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->id(null)->resetButton()->render());
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="reset" id="w1-reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::create()->name(null)->resetButton()->render());
    }
}
