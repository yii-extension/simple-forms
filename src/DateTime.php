<?php

declare(strict_types=1);

namespace Yii\Extension\Form;

use InvalidArgumentException;
use Yii\Extension\Form\Attribute\MaxMinAttributes;
use Yiisoft\Html\Tag\Input;

use function is_string;

/**
 * The input element with a type attribute whose value is "datetime" represents a control for setting the element’s
 * value to a string representing a global date and time (with timezone information).
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.datetime.html#input.datetime
 */
final class DateTime extends MaxMinAttributes
{
    /**
     * Generates a datepicker tag together with a label for the given form attribute.
     *
     * @return string the generated checkbox tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->attributes);

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.datetime.html#input.datetime.attrs.value */
        $value = $attributes['value'] ?? $this->getValue();
        unset($attributes['value']);

        if (!is_string($value) && null !== $value) {
            throw new InvalidArgumentException('DateTime widget requires a string or null value.');
        }

        return Input::tag()
            ->type('datetime')
            ->attributes($attributes)
            ->value($value === '' ? null : $value)
            ->render();
    }
}
