<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\TestSupport\Widget;

use Yii\Extension\Simple\Forms\Attribute\ModelAttributes;
use Yii\Extension\Simple\Widget\AbstractWidget;
use Yiisoft\Html\Html;

final class ModelAttributesWidget extends AbstractWidget
{
    use ModelAttributes;

    protected function run(): string
    {
        $new = clone $this;

        return '<test' . Html::renderTagAttributes($new->attributes) . '>';
    }
}
