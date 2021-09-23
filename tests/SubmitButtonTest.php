<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\SubmitButton;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Html;

final class SubmitButtonTest extends TestCase
{
    use TestTrait;

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="submit" id="submit-1" name="submit-1">',
            SubmitButton::widget()->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
    }
}
