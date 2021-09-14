<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\TestSupport\Widget;

use Yii\Extension\Simple\Forms\Attribute\WithoutModelAttribute;
use Yii\Extension\Simple\Widget\AbstractWidget;
use Yiisoft\Html\Html;

final class WithoutModelAttributeWidget extends AbstractWidget
{
    use WithoutModelAttribute;

    protected function run(): string
    {
        $new = clone $this;

        $new->attributes['id'] = $new->getId();
        $new->attributes['name'] = $new->getName();
        $new->attributes['value'] = $new->value;

        return '<test' . Html::renderTagAttributes($new->attributes) . '>';
    }
}
