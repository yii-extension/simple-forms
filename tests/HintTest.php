<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Hint;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;

final class HintTest extends TestCase
{
    public function testTag(): void
    {
        $model = new PersonalForm();

        $html = Hint::widget()->config($model, 'name')->tag('span')->render();
        $this->assertEquals('<span id="personalform-name-hint">Write your first name.</span>', $html);
    }

    public function testTagException(): void
    {
        $model = new PersonalForm();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The tag cannot be empty.');
        Hint::widget()->config($model, 'name')->tag('')->render();
    }
}
