<?php

declare(strict_types=1);

namespace Yii\Extension\Form;

use InvalidArgumentException;
use Yii\Extension\Form\Attribute\InputAttributes;
use Yii\Extension\Form\Contract\HasLengthContract;
use Yii\Extension\Form\Contract\PlaceholderContract;
use Yiisoft\Html\Tag\Textarea as TextAreaTag;

use function in_array;
use function is_string;

/**
 * Generates a textarea tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html
 */
final class TextArea extends InputAttributes implements HasLengthContract, PlaceholderContract
{
    /**
     * The expected maximum number of characters per line of text for the UA to show.
     *
     * @param int $value Positive integer.
     *
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.cols
     */
    public function cols(int $value): self
    {
        $new = clone $this;
        $new->attributes['cols'] = $value;
        return $new;
    }

    /**
     * Enables submission of a value for the directionality of the element, and gives the name of the field that
     * contains that value.
     *
     * @param string $value Any string that is not empty.
     *
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.dirname
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

    public function maxlength(int $value): self
    {
        $new = clone $this;
        $new->attributes['maxlength'] = $value;
        return $new;
    }

    public function minlength(int $value): self
    {
        $new = clone $this;
        $new->attributes['minlength'] = $value;
        return $new;
    }

    /**
     * It allows defining placeholder.
     *
     * @param string $value
     *
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.placeholder
     */
    public function placeholder(string $value): self
    {
        $new = clone $this;
        $new->attributes['placeholder'] = $value;
        return $new;
    }

    /**
     * A Boolean attribute which, if present, means this field cannot be edited by the user.
     * Its value can, however, still be changed by JavaScript code directly setting the HTMLInputElement.value
     * property.
     *
     * @param bool $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.readonly
     */
    public function readonly(bool $value = true): static
    {
        $new = clone $this;
        $new->attributes['readonly'] = $value;
        return $new;
    }

    /**
     * The number of lines of text for the UA to show.
     *
     * @param int $value
     *
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.rows
     */
    public function rows(int $value): self
    {
        $new = clone $this;
        $new->attributes['rows'] = $value;
        return $new;
    }

    /**
     * @param string $value Contains the hard and soft values.
     * `hard` Instructs the UA to insert line breaks into the submitted value of the textarea such that each line has no
     *  more characters than the value specified by the cols attribute.
     * `soft` Instructs the UA to add no line breaks to the submitted value of the textarea.
     *
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.wrap.hard
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.wrap.soft
     */
    public function wrap(string $value = 'hard'): self
    {
        if (!in_array($value, ['hard', 'soft'])) {
            throw new InvalidArgumentException('Invalid wrap value. Valid values are: hard, soft.');
        }

        $new = clone $this;
        $new->attributes['wrap'] = $value;
        return $new;
    }

    /**
     * @return string the generated textarea tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->attributes);

        /** @link https://html.spec.whatwg.org/multipage/input.html#attr-input-value */
        $value = $attributes['value'] ?? $this->getValue();
        unset($attributes['value']);

        if (!is_string($value) && null !== $value) {
            throw new InvalidArgumentException('TextArea widget must be a string or null value.');
        }

        return TextAreaTag::tag()->attributes($attributes)->content((string)$value)->render();
    }
}
