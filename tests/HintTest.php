<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Hint;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\PersonalForm;

final class HintTest extends TestCase
{
    public function testTag(): void
    {
        $html = Hint::widget()->config(new PersonalForm(), 'name')->tag('span')->render();
        $this->assertSame('<span id="personalform-name-hint">Write your first name.</span>', $html);
    }

    public function testTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The tag cannot be empty.');
        Hint::widget()->config(new PersonalForm(), 'name')->tag('')->render();
    }
}
