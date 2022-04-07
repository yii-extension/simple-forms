<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\Attribute;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Attribute\ChoiceAttributes;

final class ChoiceAttributeTest extends TestCase
{
    public function testImmutability(): void
    {
        $choiceAttributes = $this->createWidget();
        $this->assertNotSame($choiceAttributes, $choiceAttributes->required());
    }

    private function createWidget(): ChoiceAttributes
    {
        return new class () extends ChoiceAttributes {
            protected function run(): string
            {
                return '';
            }
        };
    }
}
