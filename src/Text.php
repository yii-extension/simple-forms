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
 * Generates a text input tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text
 */
final class Text extends InputAttributes implements HasLengthInterface, MatchRegularInterface, PlaceholderInterface
{
    /**
     * Enables submission of a value for the directionality of the element, and gives the name of the field that
     * contains that value.
     *
     * @param string $value Any string that is not empty.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.dirname
     */
    public function dirname(string $value): self
    {
        if (empty($value)) {
            throw new InvalidArgumentException('The value cannot be empty.');
        }

        return $this->addAttribute('dirname', $value);
    }

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
     * The height of the input with multiple is true.
     *
     * @param int $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.size
     */
    public function size(int $value): self
    {
        return $this->addAttribute('size', $value);
    }

    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->getAttributes());

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.value */
        $value = $attributes['value'] ?? $this->getAttributeValue();
        unset($attributes['value']);

        if (null !== $value && !is_string($value)) {
            throw new InvalidArgumentException('Text widget must be a string or null value.');
        }

        return Input::tag()->type('text')->attributes($attributes)->value($value === '' ? null : $value)->render();
    }
}
