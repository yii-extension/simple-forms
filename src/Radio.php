<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Html\Tag\Input\Radio as RadioTag;

/**
 * Generate a radio button input.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.radio.html
 */
final class Radio extends Input
{
    private bool $enclosedByLabel = true;

    /**
     * If the widget should be enclosed by label.
     *
     * @param bool $value If the widget should be en closed by label.
     *
     * @return static
     */
    public function enclosedByLabel(bool $value = true): self
    {
        $new = clone $this;
        $new->enclosedByLabel = $value;
        return $new;
    }

    /**
     * Label displayed next to the radio.
     *
     * It will NOT be HTML-encoded, therefore you can pass in HTML code such as an image tag. If this is is coming from
     * end users, you should {@see encode()} it to prevent XSS attacks.
     *
     * When this option is specified, the radio will be enclosed by a label tag.
     *
     * @param string $value
     *
     * @return static
     */
    public function label(string $value): self
    {
        $new = clone $this;
        $new->attributes['label'] = $value;
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
        $new->attributes['labelAttributes'] = $value;
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

        if ($new->enclosedByLabel === true) {
            /** @var string */
            $label = $new->attributes['label'] ?? $new->getLabel();

            /** @var array */
            $labelAttributes = $new->attributes['labelAttributes'] ?? [];

            unset($new->attributes['label'], $new->attributes['labelAttributes']);

            $radio = $radio->label($label, $labelAttributes);
        }

        $value = $new->getValue();

        if (is_iterable($value) || is_object($value)) {
            throw new InvalidArgumentException('The value must be a bool|float|int|string|Stringable|null.');
        }

        return $radio
            ->checked((bool) $new->getValue())
            ->id($new->getId())
            ->name($new->getInputName())
            ->uncheckValue(null)
            ->value($value)
            ->render();
    }
}
