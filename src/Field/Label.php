<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Field;

use Yiisoft\Html\Tag\Label as LabelTag;
use Yiisoft\Widget\Widget;

/**
 * Generates a label tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/label.html
 */
final class Label extends Widget
{
    private array $attributes = [];
    private bool $encode = false;
    private ?string $label = '';

    /**
     * The HTML attributes. The following special options are recognized.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = array_merge($new->attributes, $values);
        return $new;
    }

    /**
     * Whether content should be HTML-encoded.
     *
     * @param bool $value
     *
     * @return static
     */
    public function encode(bool $value): self
    {
        $new = clone $this;
        $new->encode = $value;
        return $new;
    }

    /**
     * The id of a labeled form-related element in the same document as the tag label element.
     *
     * The first element in the document with an id matching the value of the for attribute is the labeled control for
     * this label element, if it is a labeled element.
     *
     * @param string|null $value The id of a labeled form-related element in the same document as the tag label
     * element. If null, the attribute will be removed.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/label.html#label.attrs.for
     */
    public function forId(?string $value): self
    {
        $new = clone $this;
        $new->attributes['for'] = $value;
        return $new;
    }

    /**
     * This specifies the label to be displayed.
     *
     * @param string|null $value The label to be displayed.
     *
     * @return static
     *
     * Note that this will NOT be encoded.
     * - If this is not set, {@see \Yii\Extension\Simple\Model\FormModel::getAttributeLabel() will be called to get the
     * label for display (after encoding).
     */
    public function label(?string $value): self
    {
        $new = clone $this;
        $new->label = $value;
        return $new;
    }

    /**
     * @return string the generated label tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        return $new->label !== null ?
            LabelTag::tag()->attributes($new->attributes)->content($new->label)->encode($new->encode)->render()
            : '';
    }
}
