<?php

declare(strict_types=1);

namespace Yii\Extension\Form\FieldPart;

use InvalidArgumentException;
use Yii\Extension\Form\Exception\AttributeNotSetException;
use Yii\Extension\Form\Exception\FormModelNotSetException;
use Yii\Extension\FormModel\Contract\FormModelContract;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Widget\Widget;

/**
 * The widget for hint form.
 */
final class Hint extends Widget
{
    private string $attribute = '';
    private array $attributes = [];
    private bool $encode = false;
    private ?string $hint = '';
    private string $tag = 'div';
    private ?FormModelContract $formModel = null;

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
     * Set the ID of the widget.
     *
     * @param string|null $id
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-id-attribute
     */
    public function id(?string $id): self
    {
        $new = clone $this;
        $new->attributes['id'] = $id;
        return $new;
    }

    /**
     * Set hint text.
     *
     * @param string|null $value
     *
     * @return static
     */
    public function hint(?string $value): self
    {
        $new = clone $this;
        $new->hint = $value;
        return $new;
    }

    /**
     * Set the container tag name for the hint.
     *
     * @param string $value Container tag name. Set to empty value to render error messages without container tag.
     *
     * @return static
     */
    public function tag(string $value): self
    {
        $new = clone $this;
        $new->tag = $value;
        return $new;
    }

    /**
     * Generates a hint tag for the given form attribute.
     *
     * @return string the generated hint tag.
     */
    protected function run(): string
    {
        $hint = $this->hint;

        if ($this->tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        if ($hint === '') {
            $hint = $this->getFormModel()->getHint($this->getAttribute());
        }

        return match ($hint !== null && $hint !== '') {
            true => CustomTag::name($this->tag)
                ->attributes($this->attributes)
                ->content($hint)
                ->encode($this->encode)
                ->render(),
            false => '',
        };
    }

    private function getAttribute(): string
    {
        return $this->attribute;
    }

    private function getFormModel(): FormModelContract
    {
        return match (empty($this->formModel)) {
            true => throw new FormModelNotSetException(),
            false => $this->formModel,
        };
    }
}
