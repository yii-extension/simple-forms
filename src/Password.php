<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Tag\Input;

/**
 * The input element with a type attribute whose value is "password" represents a one-line plain-text edit control for
 * entering a password.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.password.html#input.password
 */
final class Password extends AbstractWidget implements HasLengthInterface, MatchRegularInterface
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
     * A Boolean attribute which, if present, means this field cannot be edited by the user.
     * Its value can, however, still be changed by JavaScript code directly setting the HTMLInputElement.value
     * property.
     *
     * @param bool $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.password.html#input.password.attrs.readonly
     */
    public function readOnly(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['readonly'] = $value;
        return $new;
    }

    /**
     * The number of options meant to be shown by the control represented by its element.
     *
     * @param int $size
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.password.html#input.password.attrs.size
     */
    public function size(int $size): self
    {
        $new = clone $this;
        $new->attributes['size'] = $size;
        return $new;
    }

    /**
     * Generates a password input tag for the given form attribute.
     *
     * @return string the generated input tag,
     */
    protected function run(): string
    {
        $new = clone $this;
        $input = Input::tag()->type('password');

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.value */
        $value = $new->getAttributeValue();

        if (null !== $value && !is_string($value)) {
            throw new InvalidArgumentException('Password widget must be a string or null value.');
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
