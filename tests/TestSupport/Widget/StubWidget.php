<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\TestSupport\Widget;

use Yii\Extension\Simple\Forms\Widget;
use Yiisoft\Html\Html;

final class StubWidget extends Widget
{
    protected function run(): string
    {
        $new = clone $this;

        return '<' . $new->getId() . Html::renderTagAttributes($new->attributes) . '>';
    }

    public function name(): self
    {
        $new = clone $this;
        $new->attributes['name'] = $new->getInputName();
        return $new;
    }
}
