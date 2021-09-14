<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yii\Extension\Simple\Forms\Attribute\CommonAttributes;
use Yii\Extension\Simple\Forms\Attribute\WithoutModelAttribute;
use Yiisoft\Html\Tag\Input;
use Yii\Extension\Simple\Widget\AbstractWidget;

/**
 * The input element with a type attribute whose value is "submit" represents a button for submitting a form.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.submit.html
 */
final class SubmitButton extends AbstractWidget
{
    use CommonAttributes;
    use WithoutModelAttribute;

    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $new = clone $this;
        $submit = Input::submitButton();

        if ($new->autoIdPrefix === '') {
            $new->autoIdPrefix = 'submit-';
        }

        if ($new->value !== '') {
            $submit = $submit->value($new->value);
        }

        return $submit->attributes($new->attributes)->id($new->getId())->name($new->getName())->render();
    }
}
