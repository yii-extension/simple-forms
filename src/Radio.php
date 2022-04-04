<?php

declare(strict_types=1);

namespace Yii\Extension\Form;

use InvalidArgumentException;
use Stringable;
use Yii\Extension\Form\Attribute\ChoiceAttributes;
use Yiisoft\Html\Tag\Input\Radio as RadioTag;

use function is_bool;
use function is_iterable;
use function is_object;

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
     * @param bool $value Whether the radio button is checked.
     *
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
     */
    public function labelAttributes(array $value = []): self
    {
        $new = clone $this;
        $new->labelAttributes = $value;
        return $new;
    }

    /**
     * @param bool|float|int|string|Stringable|null $value Value that corresponds to "unchecked" state of the input.
     *
     * @return self
     */
    public function uncheckValue(float|Stringable|bool|int|string|null $value): self
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
        $attributes = $this->build($this->attributes);

        /**
         * @var mixed
         *
         * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.radio.html#input.radio.attrs.value
         */
        $value = $this->getValue();

        /** @var iterable<int, scalar|Stringable>|scalar|Stringable|null */
        $valueDefault = $attributes['value'] ?? null;

        if (is_iterable($value) || is_object($value) || is_iterable($valueDefault) || is_object($valueDefault)) {
            throw new InvalidArgumentException('Radio widget value can not be an iterable or an object.');
        }

        $radio = RadioTag::tag();

        if ($this->enclosedByLabel) {
            $radio = $radio->label(
                empty($this->label) ? $this->getLabel() : $this->label,
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
