<?php

declare(strict_types=1);

namespace Yii\Extension\Form;

use InvalidArgumentException;
use Yii\Extension\Form\Attribute\RulesAttributes;
use Yii\Extension\Form\Contract\PlaceholderContract;
use Yiisoft\Html\Tag\Input;

use function is_string;

/**
 * The input element with a type attribute whose value is "email" represents a control for editing a list of e-mail
 * addresses given in the element’s value.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.email.html#input.email
 */
final class Email extends RulesAttributes implements PlaceholderContract
{
    /**
     * Specifies that the element allows multiple values.
     *
     * @param bool $value
     *
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.email.html#input.attrs.multiple
     */
    public function multiple(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['multiple'] = $value;
        return $new;
    }

    public function placeholder(string $value): self
    {
        $new = clone $this;
        $new->attributes['placeholder'] = $value;
        return $new;
    }

    /**
     * The number of options meant to be shown by the control represented by its element.
     *
     * @param int $size
     *
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.email.html#input.email.attrs.size
     */
    public function size(int $size): self
    {
        $new = clone $this;
        $new->attributes['size'] = $size;
        return $new;
    }

    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->attributes);

        /**
         * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.email.html#input.email.attrs.value.single
         * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.email.html#input.email.attrs.value.multiple
         */
        $value = $attributes['value'] ?? $this->getValue();
        unset($attributes['value']);

        if (!is_string($value) && null !== $value) {
            throw new InvalidArgumentException('Email widget must be a string or null value.');
        }

        return Input::tag()->type('email')->attributes($attributes)->value($value === '' ? null : $value)->render();
    }
}
