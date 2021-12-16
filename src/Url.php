<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yii\Extension\Simple\Forms\Interface\HasLengthInterface;
use Yii\Extension\Simple\Forms\Interface\MatchRegularInterface;
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

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.url.html#input.url.attrs.value */
        $value = $new->getAttributeValue();

        if (null !== $value && !is_string($value)) {
            throw new InvalidArgumentException('Url widget must be a string or null value.');
        }

        $new = $new->setId($new->getInputId());
        $new = $new->setName($new->getInputName());
        $new = $new->setValue($value);
        return Input::tag()->type('url')->attributes($new->attributes)->render();
    }
}
