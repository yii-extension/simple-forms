<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Html\Tag\Input;

/**
 * The input element with a type attribute whose value is "tel" represents a one-line plain-text edit control for
 * entering a telephone number.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.tel.html#input.tel
 */
final class Telephone extends AbstractWidget
{
    /**
     * The maxlength attribute defines the maximum number of characters (as UTF-16 code units) the user can enter into
     * a tag input.
     *
     * If no maxlength is specified, or an invalid value is specified, the tag input has no maximum length.
     *
     * @param int $value Positive integer.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.tel.html#input.tel.attrs.maxlength
     */
    public function maxlength(int $value): self
    {
        $new = clone $this;
        $new->attributes['maxlength'] = $value;
        return $new;
    }

    /**
     * The minimum number of characters (as UTF-16 code units) the user can enter into the text input.
     *
     * This must be a non-negative integer value smaller than or equal to the value specified by maxlength.
     * If no minlength is specified, or an invalid value is specified, the text input has no minimum length.
     *
     * @param int $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-minlength
     */
    public function minlength(int $value): self
    {
        $new = clone $this;
        $new->attributes['minlength'] = $value;
        return $new;
    }

    /**
     * The pattern attribute, when specified, is a regular expression that the input's value must match in order for
     * the value to pass constraint validation. It must be a valid JavaScript regular expression, as used by the
     * RegExp type.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.tel.html#input.tel.attrs.pattern
     */
    public function pattern(string $value): self
    {
        $new = clone $this;
        $new->attributes['pattern'] = $value;
        return $new;
    }

    /**
     * It allows defining placeholder.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.tel.html#input.tel.attrs.placeholder
     */
    public function placeholder(string $value): self
    {
        $new = clone $this;
        $new->attributes['placeholder'] = $value;
        return $new;
    }

    /**
     * The readonly attribute is a boolean attribute that controls whether the user can edit the form control.
     * When specified, the element is not mutable.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.tel.html#input.tel.attrs.readonly
     */
    public function readonly(): self
    {
        $new = clone $this;
        $new->attributes['readonly'] = true;
        return $new;
    }

    /**
     * The height of the text input.
     *
     * @param int $value
     *
     * @return static
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
        $new = clone $this;

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.tel.html#input.tel.attrs.value */
        $value = $new->getAttributeValue();

        if (!is_string($value) && !is_int($value) && null !== $value) {
            throw new InvalidArgumentException('Telephone widget must be a string, numeric or null.');
        }

        $new = $new->setId($new->getInputId());
        $new = $new->setName($new->getInputName());
        $new = $new->setValue($value);

        return Input::tag()->type('tel')->attributes($new->attributes)->render();
    }
}
