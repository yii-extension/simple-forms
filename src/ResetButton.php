<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input;

/**
 * The input element with a type attribute whose value is "reset" represents a button for resetting a form.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.reset.html#input.reset
 */
final class ResetButton extends AbstractWidget
{
    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $new = clone $this;
        $id = Html::generateId('w') . '-reset';
        $new->attributes['id'] ??= $id;
        $new->attributes['name'] ??= $id;

        return Input::tag()->type('reset')->attributes($new->attributes)->render();
    }
}
