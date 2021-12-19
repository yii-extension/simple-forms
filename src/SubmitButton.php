<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yii\Extension\Simple\Forms\Attribute\ButtonAttributes;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input;

/**
 * The input element with a type attribute whose value is "submit" represents a button for submitting a form.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.submit.html
 */
final class SubmitButton extends ButtonAttributes
{
    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $id = Html::generateId('w') . '-submit';

        $attributes = $this->attributes;

        if (!array_key_exists('id', $this->attributes)) {
            $attributes['id'] = $id;
        }

        if (!array_key_exists('name', $this->attributes)) {
            $attributes['name'] = $id;
        }

        return Input::tag()->type('submit')->attributes($attributes)->render();
    }
}
