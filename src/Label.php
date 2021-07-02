<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Tag\Label as LabelTag;

/**
 * @psalm-suppress MissingConstructor
 */
final class Label extends Widget
{
    private string $label = '';

    /**
     * Generates a label tag for the given form attribute.
     *
     * @return string the generated label tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        /** @var string */
        $for = ArrayHelper::remove(
            $new->attributes,
            'for',
            $new->getId($new->modelInterface->getFormName(), $new->attribute)
        );

        $label = $new->label === ''
            ? $new->modelInterface->getAttributeLabel($new->getAttributeName($new->attribute)) : $new->label;

        return LabelTag::tag()->attributes($new->attributes)->content($label)->forId($for)->render();
    }

    /**
     * The id of a labelable form-related element in the same document as the tag label element.
     *
     * The first element in the document with an id matching the value of the for attribute is the labeled control for
     * this label element, if it is a labelable element.
     *
     * @param string $value
     *
     * @return self
     */
    public function forId(string $value): self
    {
        $new = clone $this;
        $new->attributes['for'] = $value;
        return $new;
    }

    /**
     * This specifies the label to be displayed.
     *
     * @param string $value
     *
     * @return self
     *
     * Note that this will NOT be encoded.
     * - If this is not set, {@see \Yii\Extension\Simple\Forms\BaseModel::getAttributeLabel() will be called to get the
     * label for display (after encoding).
     */
    public function label(string $value): self
    {
        $new = clone $this;
        $new->label = $value;
        return $new;
    }
}
