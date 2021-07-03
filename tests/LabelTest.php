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
        $this->assertSame(
            '<label for="for-id">Name</label>',
            Label::widget()->config(new PersonalForm(), 'name')->for('for-id')->render(),
        );
    }
}
