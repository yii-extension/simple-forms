<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

final class Error extends Widget
{
    private string $message = '';

    /**
     * Generates a tag that contains the first validation error of the specified form attribute.
     *
     * @return string the generated label tag
     */
    public function run(): string
    {
        $new = clone $this;

        if ($new->message !== '') {
            $error = $new->message;
        } else {
            $error = $new->modelInterface->getFirstError($new->getAttributeName($new->attribute));
        }

        return Html::tag('div', $error, $new->attributes)->render();
    }

    public function message(string $value): self
    {
        $new = clone $this;
        $new->message = $value;
        return $new;
    }
}
