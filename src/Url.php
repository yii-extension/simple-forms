<?php

declare(strict_types=1);

namespace Yii\Extension\Form;

use InvalidArgumentException;
use Yii\Extension\Form\Attribute\InputAttributes;
use Yii\Extension\Form\Contract\HasLengthContract;
use Yii\Extension\Form\Contract\PlaceholderContract;
use Yii\Extension\Form\Contract\RegexContract;
use Yiisoft\Html\Tag\Input;

use function is_string;

/**
 * The input element with a type attribute whose value is "url" represents a control for editing an absolute URL given
 * in the element’s value.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.url.html
 */
final class Url extends InputAttributes implements HasLengthContract, PlaceholderContract, RegexContract
{
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

    public function pattern(string $value): self
    {
        $new = clone $this;
        $new->attributes['pattern'] = $value;
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
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.url.html#input.url.attrs.size
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

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.url.html#input.url.attrs.value */
        $value = $attributes['value'] ?? $this->getValue();
        unset($attributes['value']);

        if (null !== $value && !is_string($value)) {
            throw new InvalidArgumentException('Url widget must be a string or null value.');
        }

        return Input::tag()->type('url')->attributes($attributes)->value($value === '' ? null : $value)->render();
    }
}
