<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Field\DefaultValue;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Html;

final class FieldButtonTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" value="Ok">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['attributes()' => [['value' => 'Submit']]])
                ->defaultValues(['submit' => ['attributes' => ['value' => 'Ok']]])
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testContainerAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div class="container-class-widget">
        <input type="submit" id="w1-submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['containerAttributes()' => [['class' => 'container-class-definitions']]])
                ->defaultValues(['submit' => ['containerAttributes' => ['class' => 'container-class-widget']]])
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testContainerClass(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div class="container-class-widget">
        <input type="submit" id="w1-submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['containerClass()' => ['container-class-definitions']])
                ->defaultValues(['submit' => ['containerClass' => 'container-class-widget']])
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutContainer(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="submit" id="w1-submit" name="w1-submit">',
            Field::create(['container()' => [true]])
                ->defaultValues(['submit' => ['container' => false]])
                ->submitButton()
                ->render(),
        );
    }
}
