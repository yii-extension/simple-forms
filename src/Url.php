<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Tag\Input;

/**
 * The input element with a type attribute whose value is "url" represents a control for editing an absolute URL given
 * in the element’s value.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.url.html
 */
final class Url extends AbstractWidget implements HasLengthInterface, MatchRegularInterface
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

    /**
     * The height of the input with multiple is true.
     *
     * @param int $value
     *
     * @return static
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
        $new = clone $this;
        $input = Input::tag()->type('url');

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.url.html#input.url.attrs.value */
        $value = $new->getAttributeValue();

        if (null !== $value && !is_string($value)) {
            throw new InvalidArgumentException('Url widget must be a string or null value.');
        }

        if (!array_key_exists('value', $new->attributes)) {
            $input = $input->value($value === '' ? null : $value);
        }

        if (!array_key_exists('id', $new->attributes)) {
            $input = $input->id($new->getInputId());
        }

        if (!array_key_exists('name', $new->attributes)) {
            $input = $input->name($new->getInputName());
        }

        return $input->attributes($new->attributes)->render();
    }
}
