<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yii\Extension\Simple\Forms\Attribute\InputAttributes;
use Yii\Extension\Simple\Forms\Interface\HasLengthInterface;
use Yii\Extension\Simple\Forms\Interface\PlaceholderInterface;
use Yii\Extension\Simple\Forms\Validator\FieldValidator;
use Yiisoft\Html\Tag\Textarea as TextAreaTag;

/**
 * Generates a textarea tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html
 */
final class TextArea extends InputAttributes implements HasLengthInterface, PlaceholderInterface
{
    /**
     * The expected maximum number of characters per line of text for the UA to show.
     *
     * @param int $value Positive integer.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.cols
     */
    public function cols(int $value): self
    {
        return $this->addAttribute('cols', $value);
    }

    /**
     * Enables submission of a value for the directionality of the element, and gives the name of the field that
     * contains that value.
     *
     * @param string $value Any string that is not empty.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.dirname
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
    public function placeholder(string $value): self
    {
        return $this->addAttribute('placeholder', $value);
    }

    /**
     * The number of lines of text for the UA to show.
     *
     * @param int $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.rows
     */
    public function rows(int $value): self
    {
        return $this->addAttribute('rows', $value);
    }

    /**
     * @param string $value Contains the hard and soft values.
     * `hard` Instructs the UA to insert line breaks into the submitted value of the textarea such that each line has no
     *  more characters than the value specified by the cols attribute.
     * `soft` Instructs the UA to add no line breaks to the submitted value of the textarea.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.wrap.hard
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.wrap.soft
     */
    public function wrap(string $value = 'hard'): self
    {
        if (!in_array($value, ['hard', 'soft'])) {
            throw new InvalidArgumentException('Invalid wrap value. Valid values are: hard, soft.');
        }

        return $this->addAttribute('wrap', $value);
    }

    /**
     * @return string the generated textarea tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->getAttributes());

        /** @link https://html.spec.whatwg.org/multipage/input.html#attr-input-value */
        $value = $attributes['value'] ?? $this->getAttributeValue();
        unset($attributes['value']);

        if (!is_string($value) && null !== $value) {
            throw new InvalidArgumentException('TextArea widget must be a string or null value.');
        }

        return TextAreaTag::tag()->attributes($attributes)->content((string)$value)->render();
    }
}
