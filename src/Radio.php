<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yii\Extension\Simple\Forms\Attribute\CommonAttributes;
use Yii\Extension\Simple\Forms\Attribute\ModelAttributes;
use Yii\Extension\Simple\Model\Helper\HtmlModel;
use Yii\Extension\Simple\Widget\AbstractWidget;
use Yiisoft\Html\Tag\Input\Radio as RadioTag;

/**
 * The input element with a type attribute whose value is "radio" represents a selection of one item from a list of
 * items (a radio button).
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.radio.html
 */
final class Radio extends AbstractWidget
{
    use CommonAttributes;
    use ModelAttributes;

    private bool $enclosedByLabel = true;
    private string $label = '';
    private array $labelAttributes = [];

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
     * Generates a radio input element for the given model attribute.
     *
     * @return string
     */
    protected function run(): string
    {
        $new = clone $this;
        $radio = RadioTag::tag();

        /** @var bool|float|int|string|null  */
        $forceUncheckedValue = $new->attributes['forceUncheckedValue'] ?? null;

        unset($new->attributes['forceUncheckedValue']);

        $value = HtmlModel::getAttributeValue($new->getModel(), $new->attribute);

        if (is_iterable($value) || is_object($value)) {
            throw new InvalidArgumentException('Radio widget requires a bool|float|int|string|null value.');
        }

        if ($new->enclosedByLabel === true) {
            $label = $new->label !== '' ? $new->label : HtmlModel::getAttributeLabel($new->getModel(), $new->attribute);
            $radio = $radio->label($label, $new->labelAttributes);
        }

        return $radio
            ->attributes($new->attributes)
            ->checked((bool) $value)
            ->id($new->getId())
            ->name(HtmlModel::getInputName($new->getModel(), $new->attribute))
            ->uncheckValue($forceUncheckedValue)
            ->value((int) $value)
            ->render();
    }
}
