<?php

declare(strict_types=1);

namespace Yii\Extension\Form;

use InvalidArgumentException;
use Yii\Extension\Form\Attribute\MaxMinAttributes;
use Yiisoft\Html\Tag\Input;

use function is_string;

/*
 * The input element with a type attribute whose value is "datetime-local" represents a control for setting the
 * element’s value to a string representing a local date and time (with no timezone information).
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.datetime-local.html#input.datetime-local
 */
final class DateTimeLocal extends MaxMinAttributes
{
    /**
     * Generates a datepicker tag together with a label for the given form attribute.
     *
     * @return string the generated checkbox tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->attributes);

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.datetime-local.html#input.datetime-local.attrs.value */
        $value = $attributes['value'] ?? $this->getValue();
        unset($attributes['value']);

        if (!is_string($value) && null !== $value) {
            throw new InvalidArgumentException('DateTimeLocal widget requires a string or null value.');
        }

        return Input::tag()
            ->type('datetime-local')
            ->attributes($attributes)
            ->value($value === '' ? null : $value)
            ->render();
    }
}
