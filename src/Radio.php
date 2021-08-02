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
    private bool $unclosedByLabel = false;
    private bool $uncheckValue = true;

    /**
     * Generates a radio button tag together with a label for the given form attribute.
     *
     * @return string the generated radio button tag.
     */
    public function run(): string
    {
        $new = clone $this;

        $radio = RadioTag::tag();

        if ($new->unclosedByLabel === false) {
            /** @var string */
            $label = $new->attributes['label'] ?? $new->getLabel();

            /** @var array */
            $labelAttributes = $new->attributes['labelAttributes'] ?? [];

            unset($new->attributes['label'], $new->attributes['labelAttributes']);

            $radio = $radio->label($label, $labelAttributes);
        }

        if ($new->uncheckValue) {
            $radio = $radio->uncheckValue('0');
        }

        $value = $new->getValue();

        if (is_iterable($value) || is_object($value)) {
            throw new InvalidArgumentException('The value must be a bool|float|int|string|Stringable|null.');
        }

        return $radio
            ->checked((bool) $new->getValue())
            ->id($new->getId())
            ->name($new->getInputName())
            ->value($value)
            ->render();
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
     * If the widget should be un closed by label.
     *
     * @return static
     */
    public function unclosedByLabel(): self
    {
        $new = clone $this;
        $new->unclosedByLabel = true;
        return $new;
    }

    /**
     * The value associated with the uncheck state of the radio.
     *
     * When this attribute is present, a hidden input will be generated so that if the radio is not checked and is
     * submitted, the value of this attribute will still be submitted to the server via the hidden input.
     *
     * @return static
     */
    public function uncheckValue(): self
    {
        $new = clone $this;
        $new->uncheckValue = false;
        return $new;
    }
}
