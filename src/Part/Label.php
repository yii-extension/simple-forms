<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Part;

use Yii\Extension\Form\Exception\AttributeNotSetException;
use Yii\Extension\Form\Exception\FormModelNotSetException;
use Yii\Extension\Model\Attribute\FormModelAttributes;
use Yii\Extension\Model\Contract\FormModelContract;
use Yii\Extension\Widget\SimpleWidget;
use Yiisoft\Html\Tag\Label as LabelTag;

/**
 * Generates a label tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/label.html
 */
final class Label extends SimpleWidget
{
    private string $attribute = '';
    private bool $encode = false;
    private ?string $label = '';
    private ?FormModelContract $formModel = null;

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
     * @return static
     */
    public function for(FormModelContract $formModel, string $attribute): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = match ($new->getFormModel()->has($attribute)) {
            true => $attribute,
            false => throw new AttributeNotSetException(),
        };
        return $new;
    }

    /**
     * The id of a labelable form-related element in the same document as the tag label element.
     *
     * The first element in the document with an id matching the value of the for attribute is the labeled control for
     * this label element, if it is a labelable element.
     *
     * @param string|null $value The id of a labelable form-related element in the same document as the tag label
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
     * - If this is not set, {@see \Yiisoft\Form\FormModel::getAttributeLabel() will be called to get the label for
     * display (after encoding).
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
        $attributes = $this->attributes;
        $label = $this->label;

        if ($label === '') {
            $label = $this->getFormModel()->getLabel($this->getAttribute());
        }

        /** @var string */
        if (!array_key_exists('for', $attributes)) {
            $attributes['for'] = FormModelAttributes::getInputId($this->getFormModel(), $this->getAttribute());
        }

        return match (empty($label)) {
            true => '',
            false => LabelTag::tag()->attributes($attributes)->content($label)->encode($this->encode)->render(),
        };
    }

    private function getAttribute(): string
    {
        return $this->attribute;
    }

    /**
     * Return FormModelContract object.
     *
     * @return FormModelContract
     */
    private function getFormModel(): FormModelContract
    {
        return match (empty($this->formModel)) {
            true => throw new FormModelNotSetException(),
            false => $this->formModel,
        };
    }
}
