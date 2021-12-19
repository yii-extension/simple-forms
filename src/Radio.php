<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Stringable;
use Yii\Extension\Simple\Forms\Attribute\ChoiceAttributes;
use Yiisoft\Html\Tag\Input\Radio as RadioTag;

/**
 * The input element with a type attribute whose value is "radio" represents a selection of one item from a list of
 * items (a radio button).
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.radio.html
 */
final class Radio extends ChoiceAttributes
{
    private bool $checked = false;
    private bool $enclosedByLabel = true;
    private ?string $label = '';
    private array $labelAttributes = [];
    private ?string $uncheckValue = null;

    /**
     * Check the radio button.
     *
     * @param bool $checked Whether the radio button is checked.
     *
     * @return static
     */
    public function checked(bool $value = true): self
    {
        $new = clone $this;
        $new->checked = $value;
        return $new;
    }

    /**
     * If the widget should be enclosed by label.
     *
     * @param bool $value If the widget should be en closed by label.
     *
     * @return static
     */
    public function enclosedByLabel(bool $value): self
    {
        $new = clone $this;
        $new->enclosedByLabel = $value;
        return $new;
    }

    /**
     * Label displayed next to the radio.
     *
     * It will NOT be HTML-encoded, therefore you can pass in HTML code such as an image tag. If this is coming from
     * end users, you should {@see encode()} it to prevent XSS attacks.
     *
     * When this option is specified, the radio will be enclosed by a label tag.
     *
     * @param string|null $value
     *
     * @return static
     */
    public function label(?string $value): self
    {
        $new = clone $this;
        $new->label = $value;
        return $new;
    }

    /**
     * HTML attributes for the label tag.
     *
     * Do not set this option unless you set the "label" option.
     *
     * @param array $value
     *
     * @return static
     */
    public function labelAttributes(array $value = []): self
    {
        $new = clone $this;
        $new->labelAttributes = $value;
        return $new;
    }

    /**
     * The value of the input element if the radio is not checked.
     *
     * @param bool|float|int|string|Stringable|null $value Value that corresponds to "unchecked" state of the input.
     *
     * @return static
     */
    public function uncheckValue($value): self
    {
        $new = clone $this;
        $new->uncheckValue = $value === null ? null : (string) $value;
        return $new;
    }

    /**
     * Generates a radio button tag together with a label for the given form attribute.
     *
     * @return string the generated radio button tag.
     */
    protected function run(): string
    {
        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.radio.html#input.radio.attrs.value */
        $value = $this->getAttributeValue();

        if (is_iterable($value) || is_object($value)) {
            throw new InvalidArgumentException('Radio widget value can not be an iterable or an object.');
        }

        $attributes = $this->attributes;
        $attributes = $this->build($attributes);

        /** @var scalar|Stringable|null */
        $valueDefault = array_key_exists('value', $attributes) ? $attributes['value'] : null;

        $radio = RadioTag::tag();

        if ($this->enclosedByLabel === true) {
            $radio = $radio->label(
                empty($this->label) ? $this->getAttributeLabel() : $this->label,
                $this->labelAttributes,
            );
        }

        if (empty($value)) {
            $radio = $radio->checked($this->checked);
        } else {
            $radio = $radio->checked("$value" === "$valueDefault");
        }

        return $radio
            ->attributes($attributes)
            ->uncheckValue($this->uncheckValue)
            ->value(is_bool($valueDefault) ? (int) $valueDefault : $valueDefault)
            ->render();
    }
}
