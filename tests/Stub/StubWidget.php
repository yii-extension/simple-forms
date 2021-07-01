<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Stub;

use Yii\Extension\Simple\Forms\Widget;
use Yiisoft\Html\Html;

final class StubWidget extends Widget
{
    protected function run(): string
    {
        $new = clone $this;

        if (isset($new->modelInterface)) {
            $new->attributes['name'] = $new->getInputName($new->modelInterface->getFormName(), $new->attribute);
        }

        return '<' . $new->getId('PersonalForm', 'name') . Html::renderTagAttributes($new->attributes) . '>';
    }
}
