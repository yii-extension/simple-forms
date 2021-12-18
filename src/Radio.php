<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Tag\Input\Radio as RadioTag;

/**
 * The input element with a type attribute whose value is "radio" represents a selection of one item from a list of
 * items (a radio button).
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.radio.html
 */
final class Radio extends AbstractWidget
{
    private bool $checked = false;
    private bool $enclosedByLabel = true;
    private ?string $label = '';
    private array $labelAttributes = [];
    private ?string $uncheckValue = null;

    /**
     * Check the radio button.
     *
     * @return static
     */
    public function checked(): self
    {
        $new = clone $this;
        $new->checked = true;
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
        $new = clone $this;
        $radio = RadioTag::tag();

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.radio.html#input.radio.attrs.value */
        $value = $new->getAttributeValue();

        if (is_iterable($value) || is_object($value)) {
            throw new InvalidArgumentException('Radio widget value can not be an iterable or an object.');
        }

        /** @var scalar|Stringable|null */
        $valueDefault = array_key_exists('value', $new->attributes) ? $new->attributes['value'] : null;

        if ($new->enclosedByLabel === true) {
            $new->label = empty($new->label) ? $new->getAttributeLabel() : $new->label;
            $radio = $radio->label($new->label, $new->labelAttributes);
        }

        if (empty($value)) {
            $radio = $radio->checked($new->checked);
        } else {
            $radio = $radio->checked("$value" === "$valueDefault");
        }

        $new = $new->setId($new->getInputId());
        $new = $new->setName($new->getInputName());

        return $radio
            ->attributes($new->attributes)
            ->uncheckValue($new->uncheckValue)
            ->value(is_bool($valueDefault) ? (int) $valueDefault : $valueDefault)
            ->render();
    }
}
