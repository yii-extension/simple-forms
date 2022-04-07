<?php

declare(strict_types=1);

namespace Yii\Extension\Form;

use InvalidArgumentException;
use Yii\Extension\Form\Attribute\RulesAttributes;
use Yii\Extension\Form\Contract\PlaceholderContract;
use Yiisoft\Html\Tag\Input;

use function is_string;

/**
 * Generates a text input tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text
 */
final class Text extends RulesAttributes implements PlaceholderContract
{
    /**
     * Enables submission of a value for the directionality of the element, and gives the name of the field that
     * contains that value.
     *
     * @param string $value Any string that is not empty.
     *
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.dirname
     */
    public function dirname(string $value): self
    {
        if (empty($value)) {
            throw new InvalidArgumentException('The value cannot be empty.');
        }

        $new = clone $this;
        $new->attributes['dirname'] = $value;
        return $new;
    }

    public function placeholder(string $value): self
    {
        $new = clone $this;
        $new->attributes['placeholder'] = $value;
        return $new;
    }

    /**
     * The height of the input with multiple is true.
     *
     * @param int $value
     *
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.size
     */
    public function size(int $value): self
    {
        $new = clone $this;
        $new->attributes['size'] = $value;
        return $new;
    }

    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->attributes);

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.value */
        $value = $attributes['value'] ?? $this->getValue();
        unset($attributes['value']);

        if (null !== $value && !is_string($value)) {
            throw new InvalidArgumentException('Text widget must be a string or null value.');
        }

        return Input::tag()->type('text')->attributes($attributes)->value($value === '' ? null : $value)->render();
    }
}
