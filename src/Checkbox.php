<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Html\Tag\Input\Checkbox as CheckboxTag;

/**
 * Generates a checkbox tag together with a label for the given form attribute.
 *
 * This method will generate the "checked" tag attribute according to the form attribute value.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.checkbox.html#input.checkbox
 */
final class Checkbox extends Widget
{
    private bool $unclosedByLabel = false;
    private bool $uncheckValue = true;

    /**
     * @return string the generated checkbox tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        $checkbox = CheckboxTag::tag();

        if ($new->unclosedByLabel === false) {
            /** @var string */
            $label = $new->attributes['label'] ?? $new->getLabel();

            /** @var array */
            $labelAttributes = $new->attributes['labelAttributes'] ?? [];

            unset($new->attributes['label'], $new->attributes['labelAttributes']);

            $checkbox = $checkbox->label($label, $labelAttributes);
        }

        if ($new->uncheckValue) {
            $checkbox = $checkbox->uncheckValue('0');
        }

        $value = $new->getValue();

        if (is_iterable($value) || is_object($value)) {
            throw new InvalidArgumentException('The value must be a bool|float|int|string|Stringable|null.');
        }

        return $checkbox
            ->attributes($new->attributes)
            ->checked((bool) $new->getValue())
            ->id($new->getId())
            ->name($new->getInputName())
            ->value($value)
            ->render();
    }

    /**
     * Label displayed next to the checkbox.
     *
     * It will NOT be HTML-encoded, therefore you can pass in HTML code such as an image tag. If this is is coming from
     * end users, you should {@see encode()} it to prevent XSS attacks.
     *
     * When this option is specified, the checkbox will be enclosed by a label tag.
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
     * Do not set this option unless you set the "label" attributes.
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
     * If the widget should be unclosed by label.
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
     * The value associated with the uncheck state of the checkbox.
     *
     * When this attribute is present, a hidden input will be generated so that if the checkbox is not checked and
     * is submitted, the value of this attribute will still be submitted to the server via the hidden input.
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
