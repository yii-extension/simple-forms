<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Attribute;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Attribute\ButtonAttributes;

final class ButtonAttributeTest extends TestCase
{
    public function testImmutability(): void
    {
        $buttonAttributes = $this->createWidget();
        $this->assertNotSame($buttonAttributes, $buttonAttributes->form(''));
    }

    private function createWidget(): ButtonAttributes
    {
        return new class () extends ButtonAttributes {
            protected function run(): string
            {
                return '';
            }
        };
    }
}
