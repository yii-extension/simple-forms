<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input;

/**
 * The input element with a type attribute whose value is "reset" represents a button for resetting a form.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.reset.html#input.reset
 */
final class ResetButton extends AbstractForm
{
    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $new = clone $this;
        $input = Input::tag()->type('reset');
        $id = Html::generateId('w') . '-reset';

        if (!array_key_exists('id', $new->attributes)) {
            $input = $input->id($id);
        }

        if (!array_key_exists('name', $new->attributes)) {
            $input = $input->name($id);
        }

        return $input->attributes($new->attributes)->render();
    }
}
