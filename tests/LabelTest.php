<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Label;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;

final class LabelTest extends TestCase
{
    public function testForId(): void
    {
        $model = new PersonalForm();

        $html = Label::widget()->config($model, 'name')->forId('for-id')->render();
        $this->assertEquals('<label for="for-id">Name</label>', $html);
    }
}
