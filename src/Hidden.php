<?php

declare(strict_types=1);

namespace Yii\Extension\Form;

use InvalidArgumentException;
use Yii\Extension\Form\Attribute\InputAttributes;
use Yiisoft\Html\Tag\Input;

use function array_key_exists;
use function is_numeric;
use function is_string;

/**
 * The input element with a type attribute whose value is "hidden" represents a value that is not intended to be
 * examined or manipulated by the user.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.hidden.html#input.hidden
 */
final class Hidden extends InputAttributes
{
    /**
     * Generates a hidden input tag for the given form attribute.
     *
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $attributes = $this->attributes;

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.hidden.html#input.hidden.attrs.value */
        $value = $attributes['value'] ?? $this->getValue();
        unset($attributes['value']);

        if (!is_string($value) && !is_numeric($value) && null !== $value) {
            throw new InvalidArgumentException('Hidden widget requires a string, numeric or null value.');
        }

        if (!array_key_exists('name', $attributes)) {
            $attributes['name'] = $this->getInputName();
        }

        return Input::tag()->type('hidden')->attributes($attributes)->value($value === '' ? null : $value)->render();
    }
}
