<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Attribute;

use Yiisoft\Html\Html;

trait GlobalAttributes
{
    protected array $attributes = [];

    /**
     * Set attribute value.
     *
     * @param string $name Name of the attribute.
     * @param mixed $value Value of the attribute.
     *
     * @return static
     */
    public function addAttribute(string $name, $value): self
    {
        $new = clone $this;
        $new->attributes[$name] = $value;
        return $new;
    }

    /**
     * Focus on the control (put cursor into it) when the page loads.
     * Only one form element could be in focus at the same time.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#autofocusing-a-form-control-the-autofocus-attribute
     */
    public function autofocus(): self
    {
        $new = clone $this;
        $new->attributes['autofocus'] = true;
        return $new;
    }

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
     * Set CSS class of the field widget.
     *
     * @param string $class
     *
     * @return static
     */
    public function class(string $class): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, $class);
        return $new;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
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
     * The name part of the name/value pair associated with this element for the purposes of form submission.
     *
     * @param string|null The name of the widget.
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-name
     */
    public function name(?string $value): self
    {
        $new = clone $this;
        $new->attributes['name'] = $value;
        return $new;
    }

    /**
     * The tabindex global attribute indicates that its element can be focused, and where it participates in sequential
     * keyboard navigation (usually with the Tab key, hence the name).
     *
     * It accepts an integer as a value, with different results depending on the integer's value:
     *
     * - A negative value (usually tabindex="-1") means that the element is not reachable via sequential keyboard
     * navigation, but could be focused with Javascript or visually. It's mostly useful to create accessible widgets
     * with JavaScript.
     * - tabindex="0" means that the element should be focusable in sequential keyboard navigation, but its order is
     * defined by the document's source order.
     * - A positive value means the element should be focusable in sequential keyboard navigation, with its order
     * defined by the value of the number. That is, tabindex="4" is focused before tabindex="5", but after tabindex="3".
     *
     * @param int $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/interaction.html#attr-tabindex
     */
    public function tabIndex(int $value): self
    {
        $new = clone $this;
        $new->attributes['tabindex'] = $value;
        return $new;
    }

    /**
     * The title global attribute contains text representing advisory information related to the element it belongs to.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#attr-title
     */
    public function title(string $value): self
    {
        $new = clone $this;
        $new->attributes['title'] = $value;
        return $new;
    }

    /**
     * The value obtained by the form model
     *
     * @param array|object|string|bool|int|float|null $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-value
     */
    public function value($value): self
    {
        $new = clone $this;
        $new->attributes['value'] = $value;
        return $new;
    }
}
