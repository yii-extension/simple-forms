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
 * The input element with a type attribute whose value is "url" represents a control for editing an absolute URL given
 * in the element’s value.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.url.html
 */
final class Url extends InputAttributes implements HasLengthInterface, MatchRegularInterface, PlaceholderInterface
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
        return $this->addAttribute('size', $value);
    }

    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->getAttributes());

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.url.html#input.url.attrs.value */
        $value = $attributes['value'] ?? $this->getAttributeValue();
        unset($attributes['value']);

        if (null !== $value && !is_string($value)) {
            throw new InvalidArgumentException('Url widget must be a string or null value.');
        }

        return Input::tag()->type('url')->attributes($attributes)->value($value === '' ? null : $value)->render();
    }
}
