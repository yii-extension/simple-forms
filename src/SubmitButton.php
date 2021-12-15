<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input;

/**
 * The input element with a type attribute whose value is "submit" represents a button for submitting a form.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.submit.html
 */
final class SubmitButton extends AbstractForm
{
    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $new = clone $this;
        $input = Input::tag()->type('submit');
        $id = Html::generateId('w') . '-submit';

        if (!array_key_exists('id', $new->attributes)) {
            $input = $input->id($id);
        }

        if (!array_key_exists('name', $new->attributes)) {
            $input = $input->name($id);
        }

        return $input->attributes($new->attributes)->render();
    }
}
