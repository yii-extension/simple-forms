<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Field\DefaultValue;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Html;

final class FieldButtonGroupTest extends TestCase
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
        <div>
        <input type="button" id="w1-button" class="btn btn-success" name="w1-button" value="Submit">
        <input type="button" id="w2-button" class="btn btn-success" name="w2-button" value="Reset">
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['attributes()' => [['class' => 'btn btn-primary']]])
                ->defaultValues(['buttonGroup' => ['attributes' => ['class' => 'btn btn-success']]])
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testFieldContainerAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div class="container-class-widget">
        <div>
        <input type="button" id="w1-button" name="w1-button" value="Submit">
        <input type="button" id="w2-button" name="w2-button" value="Reset">
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['containerAttributes()' => [['class' => 'container-class-definitions']]])
                ->defaultValues(
                    [
                        'buttonGroup' => [
                            'containerAttributes' => ['class' => 'container-class-widget'],
                        ],
                    ],
                )
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testFieldContainerClass(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div class="container-class-widget">
        <div>
        <input type="button" id="w1-button" name="w1-button" value="Submit">
        <input type="button" id="w2-button" name="w2-button" value="Reset">
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['containerClass()' => ['container-class-definitions']])
                ->defaultValues(
                    [
                        'buttonGroup' => [
                            'containerClass' => 'container-class-widget',
                        ],
                    ],
                )
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
            Field::widget()
                ->container(false)
                ->defaultValues(['buttonGroup' => ['definitions' => ['container()' => [false]]]])
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testFieldAndButtonContainerAttributes(): void
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
            Field::widget(['containerClass()' => ['row']])
                ->defaultValues(
                    [
                        'buttonGroup' => [
                            'definitions' => [
                                'containerClass()' => ['col-sm-10 offset-sm-2'],
                            ],
                        ],
                    ],
                )
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
                ->render(),
        );
    }
}
