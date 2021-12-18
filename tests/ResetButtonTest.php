<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\ResetButton;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Html;

final class ResetButtonTest extends TestCase
{
    use TestTrait;

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame('<input type="reset" id="w1-reset" name="w1-reset">', ResetButton::widget()->render());
    }
}
