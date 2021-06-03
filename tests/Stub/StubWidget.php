<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Stub;

use Yii\Extension\Simple\Forms\Widget;

final class StubWidget extends Widget
{
    protected function run(): string
    {
        return '<' . $this->getId('PersonalForm', 'name') . '>';
    }
}
