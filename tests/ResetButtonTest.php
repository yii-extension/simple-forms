<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\ResetButton;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Html;

final class ResetButtonTest extends TestCase
{
    use TestTrait;

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="reset" id="reset-1" name="reset-1">',
            ResetButton::widget()->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
    }
}
