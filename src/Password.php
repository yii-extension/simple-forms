<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yii\Extension\Simple\Forms\Attribute\InputAttributes;
use Yii\Extension\Simple\Forms\Interface\HasLengthInterface;
use Yii\Extension\Simple\Forms\Interface\MatchRegularInterface;
use Yii\Extension\Simple\Forms\Interface\PlaceholderInterface;
use Yiisoft\Html\Tag\Input;

/**
 * The input element with a type attribute whose value is "password" represents a one-line plain-text edit control for
 * entering a password.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.password.html#input.password
 */
final class Password extends InputAttributes implements HasLengthInterface, MatchRegularInterface, PlaceholderInterface
{
    /**
     * @return static
     */
    public function maxlength(int $value): self
    {
        return $this->addAttribute('maxlength', $value);
    }

    /**
     * @return static
     */
    public function minlength(int $value): self
    {
        return $this->addAttribute('minlength', $value);
    }

    /**
     * @return static
     */
    public function pattern(string $value): self
    {
        return $this->addAttribute('pattern', $value);
    }

    /**
     * @return static
     */
    public function placeholder(string $value): self
    {
        return $this->addAttribute('placeholder', $value);
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
        return $this->addAttribute('size', $size);
    }

    /**
     * Generates a password input tag for the given form attribute.
     *
     * @return string the generated input tag,
     */
    protected function run(): string
    {
        $attributes = $this->build($this->getAttributes());

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.value */
        $value = $attributes['value'] ?? $this->getAttributeValue();
        unset($attributes['value']);

        if (null !== $value && !is_string($value)) {
            throw new InvalidArgumentException('Password widget must be a string or null value.');
        }

        return Input::tag()->type('password')->attributes($attributes)->value($value === '' ? null : $value)->render();
    }
}
