<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Attribute;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Attribute\InputAttributes;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class InputAttributeTest extends TestCase
{
    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $inputAttributes = $this->createWidget();
        $this->assertNotSame($inputAttributes, $inputAttributes->ariaDescribedBy(''));
        $this->assertNotSame($inputAttributes, $inputAttributes->ariaLabel(''));
        $this->assertNotSame($inputAttributes, $inputAttributes->form(''));
        $this->assertNotSame($inputAttributes, $inputAttributes->readonly(true));
        $this->assertNotSame($inputAttributes, $inputAttributes->required());
    }

    private function createWidget(): InputAttributes
    {
        return new class () extends InputAttributes {
            protected function run(): string
            {
                return '';
            }
        };
    }
}
