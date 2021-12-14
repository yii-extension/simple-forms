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

        $value = $new->getAttributeValue();

        if (null !== $value && !is_string($value)) {
            throw new InvalidArgumentException('Password widget must be a string or null value.');
        }

        $new->attributes['id'] = ArrayHelper::getValue($new->attributes, 'id', $new->getInputId());
        $new->attributes['name'] = ArrayHelper::getValue($new->attributes, 'name', $new->getInputName());

        return Input::tag()
            ->type('password')
            ->attributes($new->attributes)
            ->value($value === '' ? null : $value)
            ->render();
    }
}
