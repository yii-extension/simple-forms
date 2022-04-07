<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Form\ButtonGroup;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;

final class ButtonGroupTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="Submit" id="w1-button" class="btn btn-lg" name="w1-button" value="Submit">
        <input type="Reset" id="w2-button" class="btn btn-lg" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->attributes(['class' => 'btn btn-lg'])
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testAutofocus(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="Submit" id="w1-button" name="w1-button" value="Submit" autofocus>
        <input type="Reset" id="w2-button" name="w2-button" value="Reset" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->autofocus()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testContainerAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div class="btn-group">
        <input type="Submit" id="w1-button" name="w1-button" value="Submit">
        <input type="Reset" id="w2-button" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->containerAttributes(['class' => 'btn-group'])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testContainerClass(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div class="btn-group">
        <input type="Submit" id="w1-button" name="w1-button" value="Submit">
        <input type="Reset" id="w2-button" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->containerClass('btn-group')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testContainerId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div id="id-test">
        <input type="Submit" id="w1-button" name="w1-button" value="Submit">
        <input type="Reset" id="w2-button" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->containerId('id-test')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testContainerName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div name="name-test">
        <input type="Submit" id="w1-button" name="w1-button" value="Submit">
        <input type="Reset" id="w2-button" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->containerName('name-test')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testDisabled(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="Submit" id="w1-button" name="w1-button" value="Submit" disabled>
        <input type="Reset" id="w2-button" name="w2-button" value="Reset" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->disabled()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testForm(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="Submit" id="w1-button" name="w1-button" value="Submit" form="form-register">
        <input type="Reset" id="w2-button" name="w2-button" value="Reset" form="form-register">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->form('form-register')
                ->render(),
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
        <input type="Submit" id="id-test" name="w1-button" value="Submit">
        <input type="Reset" id="id-test" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->id('id-test')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $buttonGroup = ButtonGroup::create();
        $this->assertNotSame($buttonGroup, $buttonGroup->buttons([]));
        $this->assertNotSame($buttonGroup, $buttonGroup->container(true));
        $this->assertNotSame($buttonGroup, $buttonGroup->containerAttributes([]));
        $this->assertNotSame($buttonGroup, $buttonGroup->containerClass(''));
        $this->assertNotSame($buttonGroup, $buttonGroup->containerId(null));
        $this->assertNotSame($buttonGroup, $buttonGroup->containerName(null));
        $this->assertNotSame($buttonGroup, $buttonGroup->individualButtonAttributes([]));
    }

    /**
     * @throws ReflectionException
     */
    public function testIndividualButtonAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="Submit" id="w1-button" class="btn btn-lg" name="w1-button" value="Submit">
        <input type="Reset" id="w2-button" class="btn btn-md" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->individualButtonAttributes(['0' => ['class' => 'btn btn-lg'], '1' => ['class' => 'btn btn-md']])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="Submit" id="w1-button" name="name-test" value="Submit">
        <input type="Reset" id="w2-button" name="name-test" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->name('name-test')
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="Submit" id="w1-button" name="w1-button" value="Submit">
        <input type="Reset" id="w2-button" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testRenderWithTag(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <button type="submit">Send</button>
        <button type="reset">Reset</button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([Button::tag()->type('submit')->content('Send'), Button::tag()->type('reset')->content('Reset')])
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testTabindex(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="Submit" id="w1-button" name="w1-button" value="Submit" tabindex="1">
        <input type="Reset" id="w2-button" name="w2-button" value="Reset" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->tabindex(1)
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="Submit" id="w1-button" name="w1-button" value="Submit">
        <input type="Reset" id="w2-button" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->value(null)
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testVisible(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="Reset" id="w2-button" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons(
                    [
                        ['label' => 'Submit', 'type' => 'Submit', 'visible' => false],
                        ['label' => 'Reset', 'type' => 'Reset'],
                    ]
                )
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutContainer(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <input type="Submit" id="w1-button" name="w1-button" value="Submit">
        <input type="Reset" id="w2-button" name="w2-button" value="Reset">
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->container(false)
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="Submit" name="w1-button" value="Submit">
        <input type="Reset" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->id(null)
                ->render(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testWithoutName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="Submit" id="w1-button" value="Submit">
        <input type="Reset" id="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            ButtonGroup::create()
                ->buttons([['label' => 'Submit', 'type' => 'Submit'], ['label' => 'Reset', 'type' => 'Reset']])
                ->name(null)
                ->render(),
        );
    }
}
