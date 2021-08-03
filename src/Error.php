<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yii\Extension\Simple\Forms\Attribute\FormAttribute;
use Yiisoft\Html\Tag\Div;

final class Error extends FormAttribute
{
    private string $message = '';

    public function message(string $value): self
    {
        $new = clone $this;
        $new->message = $value;
        return $new;
    }

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
            $error = $new->getFirstError();
        }

        return Div::tag()->attributes($new->attributes)->content($error)->render();
    }
}
