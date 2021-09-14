<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yii\Extension\Simple\Forms\Attribute\CommonAttributes;
use Yii\Extension\Simple\Forms\Attribute\WithoutModelAttribute;
use Yiisoft\Html\Tag\Input;
use Yii\Extension\Simple\Widget\AbstractWidget;

/**
 * The input element with a type attribute whose value is "reset" represents a button for resetting a form.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.reset.html#input.reset
 */
final class ResetButton extends AbstractWidget
{
    use CommonAttributes;
    use WithoutModelAttribute;

    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $new = clone $this;
        $input = Input::tag()->type('reset');

        if ($new->autoIdPrefix === '') {
            $new->autoIdPrefix = 'reset-';
        }

        if ($new->value !== '') {
            $input = $input->value($new->value);
        }

        return $input ->attributes($new->attributes)->id($new->getId())->name($new->getName())->render();
    }
}
