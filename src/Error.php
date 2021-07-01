<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yiisoft\Html\Tag\Div;

final class Error extends Widget
{
    private string $message = '';

    /**
     * Generates a tag that contains the first validation error of the specified form attribute.
     *
     * @return string the generated label tag
     */
    protected function run(): string
    {
        $new = clone $this;

        if ($new->message !== '') {
            $error = $new->message;
        } else {
            $error = $new->modelInterface->getFirstError($new->getAttributeName($new->attribute));
        }

        return Div::tag()->attributes($new->attributes)->content($error)->render();
    }

    public function message(string $value): self
    {
        $new = clone $this;
        $new->message = $value;
        return $new;
    }
}
