<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Attribute;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Attribute\ButtonAttributes;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class ButtonAttributeTest extends TestCase
{
    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
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
