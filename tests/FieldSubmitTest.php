<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Html;

final class FieldSubmitTest extends TestCase
{
    use TestTrait;

    public function testAutoIdPrefix(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="s-1" name="s-1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->submitButton(['autoIdPrefix' => 's-'])->render(),
        );
    }

    public function testAttributes(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="submit-1" name="submit-1" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->submitButton(['disabled' => true])->render(),
        );
    }

    public function testId(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="test-id" name="test-id">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->submitButton(['id' => 'test-id'])->render(),
        );
    }

    public function testName(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="submit-1" name="test-name">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->submitButton(['name' => 'test-name'])->render(),
        );
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="submit-1" name="submit-1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->submitButton()->render(),
        );
    }

    public function testValue(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="submit-1" name="submit-1" value="Save">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->submitButton(['value' => 'Save'])->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
    }
}
