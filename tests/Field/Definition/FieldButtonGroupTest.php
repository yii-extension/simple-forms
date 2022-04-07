<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Field\Definition;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Html;

final class FieldButtonGroupTest extends TestCase
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
        <div>
        <input type="button" id="w1-button" class="btn btn-primary" name="w1-button" value="Submit">
        <input type="button" id="w2-button" class="btn btn-primary" name="w2-button" value="Reset">
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['attributes()' => [['class' => 'btn btn-primary']]])
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
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
        <div class="container-class-definitions">
        <div>
        <input type="button" id="w1-button" name="w1-button" value="Submit">
        <input type="button" id="w2-button" name="w2-button" value="Reset">
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['containerAttributes()' => [['class' => 'container-class-definitions']]])
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
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
        <div class="container-class-definitions">
        <div>
        <input type="button" id="w1-button" name="w1-button" value="Submit">
        <input type="button" id="w2-button" name="w2-button" value="Reset">
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(['containerClass()' => ['container-class-definitions']])
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutContainer(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="button" id="w1-button" name="w1-button" value="Submit">
        <input type="button" id="w2-button" name="w2-button" value="Reset">
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create(
                [
                    'container()' => [false],
                    'defaultValues()' => [
                        [
                            'buttonGroup' => [
                                'definitions' => [
                                    'container()' => [false],
                                ],
                            ],
                        ],
                    ],
                ],
            )
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testFieldAndButtonContainerClass(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div class="row">
        <div class="col-sm-10 offset-sm-2">
        <input type="button" id="w1-button" name="w1-button" value="Submit">
        <input type="button" id="w2-button" name="w2-button" value="Reset">
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create([
                'containerClass()' => ['row'],
                'defaultValues()' => [
                    [
                        'buttonGroup' => [
                            'definitions' => [
                                'containerClass()' => ['col-sm-10 offset-sm-2'],
                            ],
                        ],
                    ],
                ],
            ])
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
                ->render(),
        );
    }
}
