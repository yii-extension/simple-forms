<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yii\Extension\Simple\Forms\Attribute\CommonAttributes;
use Yii\Extension\Simple\Forms\Attribute\WithoutModelAttribute;
use Yii\Extension\Simple\Widget\AbstractWidget;
use Yiisoft\Html\Tag\Input;

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
     * Generates a submit button input element.
     *
     * @return string
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
