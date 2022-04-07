<?php

declare(strict_types=1);

namespace Yii\Extension\Form;

use InvalidArgumentException;
use Yii\Extension\Form\Attribute\RulesAttributes;
use Yii\Extension\Form\Contract\PlaceholderContract;
use Yiisoft\Html\Tag\Input;

use function is_int;
use function is_string;

/**
 * The input element with a type attribute whose value is "tel" represents a one-line plain-text edit control for
 * entering a telephone number.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.tel.html#input.tel
 */
final class Telephone extends RulesAttributes implements PlaceholderContract
{
    public function placeholder(string $value): self
    {
        $new = clone $this;
        $new->attributes['placeholder'] = $value;
        return $new;
    }

    /**
     * The height of the text input.
     *
     * @param int $value
     *
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.tel.html#input.tel.attrs.size
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

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.tel.html#input.tel.attrs.value */
        $value = $attributes['value'] ?? $this->getValue();
        unset($attributes['value']);

        if (!is_string($value) && !is_int($value) && null !== $value) {
            throw new InvalidArgumentException('Telephone widget must be a string, numeric or null.');
        }

        return Input::tag()->type('tel')->attributes($attributes)->value($value === '' ? null : $value)->render();
    }
}
