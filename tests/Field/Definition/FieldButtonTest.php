<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Field\Definition;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Html;

final class FieldButtonTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" value="Submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['attributes()' => [['value' => 'Submit']]])->submitButton()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div class="container-class-definitions">
        <input type="submit" id="w1-submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['containerAttributes()' => [['class' => 'container-class-definitions']]])
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerClass(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div class="container-class-definitions">
        <input type="submit" id="w1-submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['containerClass()' => ['container-class-definitions']])
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutContainer(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="submit" id="w1-submit" name="w1-submit">',
            Field::create(['container()' => [false]])->submitButton()->render(),
        );
    }
}
