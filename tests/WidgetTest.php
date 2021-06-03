<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use Yii\Extension\Simple\Forms\Tests\Stub\StubWidget;

final class WidgetTest extends TestCase
{
    public function testGetId(): void
    {
        $id = StubWidget::widget()->render();
        $this->assertSame('<personalform-name>', $id);
    }

    public function testId(): void
    {
        $id = StubWidget::widget()->id('test-2')->render();
        $this->assertSame('<test-2>', $id);
    }
}
