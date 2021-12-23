<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yii\Extension\Simple\Forms\Attribute\GlobalAttributes;
use Yii\Extension\Simple\Model\FormModelInterface;
use Yii\Extension\Simple\Model\Helper\HtmlForm;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

abstract class AbstractField extends Widget
{
    use GlobalAttributes;

    protected bool $ariaDescribedBy = false;
    protected bool $encode = false;
    protected array $buttonsIndividualAttributes = [];
    protected bool $container = false;
    protected array $containerAttributes = [];
    protected string $containerClass = '';
    protected ?string $error = '';
    protected array $errorAttributes = [];
    protected string $errorTag = 'div';
    protected string|null $hint = '';
    protected array $hintAttributes = [];
    protected string $hintTag = 'div';
    protected string $inputClass = '';
    protected string $invalidClass = '';
    protected string|null $label = '';
    protected array $labelAttributes = [];
    protected string|null $placeHolder = null;
    protected string $validClass = '';

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
     * Set aria-label attribute.
     *
     * @param string $value
     *
     * @return static
     */
    public function ariaLabel(string $value): self
    {
        $new = clone $this;
        $new->attributes['aria-label'] = $value;
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
     * Set individual attributes for the buttons widgets.
     *
     * @return static
     */
    public function buttonsIndividualAttributes(array $value): self
    {
        $new = clone $this;
        $new->buttonsIndividualAttributes = $value;
        return $new;
    }

    /**
     * Set container attributes.
     *
     * @return static
     */
    public function containerAttributes(array $value): self
    {
        $new = clone $this;
        $new->containerAttributes = $value;
        return $new;
    }

    /**
     * Set container ID.
     *
     * @return static
     */
    public function containerId(string $value): self
    {
        $new = clone $this;
        $new->containerAttributes['id'] = $value;
        return $new;
    }

    /**
     * Set container name.
     *
     * @return static
     */
    public function containerName(string $value): self
    {
        $new = clone $this;
        $new->containerAttributes['name'] = $value;
        return $new;
    }

    /**
     * Set CSS class for the container field.
     *
     * @return static
     */
    public function containerClass(string $value): self
    {
        $new = clone $this;
        $new->containerClass = $value;
        return $new;
    }

    /**
     * Set whether the element is disabled or not.
     *
     * If this attribute is set to `true`, the element is disabled. Disabled elements are usually drawn with grayed-out
     * text.
     * If the element is disabled, it does not respond to user actions, it cannot be focused, and the command event
     * will not fire. In the case of form elements, it will not be submitted. Do not set the attribute to true, as
     * this will suggest you can set it to `false` to enable the element again, which is not the case.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-disabledformelements-disabled
     */
    public function disabled(): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = true;
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
    public function error(string $value): self
    {
        $new = clone $this;
        $new->error = $value;
        return $new;
    }

    /**
     * @return static
     */
    public function errorAttributes(array $value): self
    {
        $new = clone $this;
        $new->errorAttributes = $value;
        return $new;
    }

    /**
     * @return static
     */
    public function errorClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->errorAttributes, $value);
        return $new;
    }

    /**
     * @return static
     */
    public function errorTag(string $value): self
    {
        $new = clone $this;
        $new->errorTag = $value;
        return $new;
    }

    /**
     * Specifies the form element the tag input element belongs to. The value of this attribute must be the id
     * attribute of a {@see Form} element in the same document.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fae-form
     */
    public function form(string $value): self
    {
        $new = clone $this;
        $new->attributes['form'] = $value;
        return $new;
    }

    /**
     * @return static
     */
    public function hint(string $value): self
    {
        $new = clone $this;
        $new->hint = $value;
        return $new;
    }

    /**
     * The HTML attributes for hint widget. The following special options are recognized.
     *
     * @param array $value Attribute values indexed by attribute names.
     *
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function hintAttributes(array $value): self
    {
        $new = clone $this;
        $new->hintAttributes = $value;
        return $new;
    }

    /**
     * Set CSS class names to the hint widget.
     *
     * @param string $value CSS class names.
     *
     * @return static
     */
    public function hintClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->hintAttributes, $value);
        return $new;
    }

    /**
     * Set the tag name of the hint widget.
     *
     * @param string $value The tag name.
     *
     * @return static
     */
    public function hintTag(string $value): self
    {
        $new = clone $this;
        $new->hintTag = $value;
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
     * Set CSS class names to widget for invalid field.
     *
     * @param string $value CSS class names.
     *
     * @return static
     */
    public function invalidClass(string $value): self
    {
        $new = clone $this;
        $new->invalidClass = $value;
        return $new;
    }

    /**
     * Set CSS class of the field widget.
     *
     * @param string $class
     *
     * @return static
     */
    public function inputClass(string $class): self
    {
        $new = clone $this;
        $new->inputClass = $class;
        return $new;
    }

    /**
     * Set the label of the field.
     *
     * @param string $value The label.
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
     * The HTML attributes for label widget. The following special options are recognized.
     *
     * @param array $value Attribute values indexed by attribute names.
     *
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function labelAttributes(array $value): self
    {
        $new = clone $this;
        $new->labelAttributes = $value;
        return $new;
    }

    /**
     * Set CSS class names to the label widget.
     *
     * @param string $value CSS class names.
     *
     * @return static
     */
    public function labelClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->labelAttributes, $value);
        return $new;
    }

    /**
     * Set attributes for id the label widget.
     *
     * @param string $value
     *
     * @return static
     */
    public function labelFor(string $value): self
    {
        $new = clone $this;
        $new->labelAttributes['for'] = $value;
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
     * Set placeholder attribute for the field.
     *
     * @param string|null $value The placeholder.
     *
     * @return static
     */
    public function placeHolder(?string $value): self
    {
        $new = clone $this;
        $new->placeHolder = $value;
        return $new;
    }

    /**
     * If it is required to fill in a value in order to submit the form.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-required-attribute
     */
    public function required(): self
    {
        $new = clone $this;
        $new->attributes['required'] = true;
        return $new;
    }

    /**
     * Set aria-describedby attribute.
     *
     * @param bool $value Whether to add aria-describedby attribute.
     * @return static
     *
     * @link https://www.w3.org/TR/WCAG20-TECHS/ARIA1.html
     */
    public function setAriaDescribedBy(bool $value): self
    {
        $new = clone $this;
        $new->ariaDescribedBy = $value;
        return $new;
    }

    /**
     * Set CSS class names to widget for valid field.
     *
     * @param string $value CSS class names.
     *
     * @return static
     */
    public function validClass(string $value): self
    {
        $new = clone $this;
        $new->validClass = $value;
        return $new;
    }

    /**
     * Disabled container for field.
     *
     * @return static
     */
    public function withoutContainer(): self
    {
        $new = clone $this;
        $new->container = true;
        return $new;
    }

    /**
     * Disabled error field part.
     *
     * @return static
     */
    public function withoutError(): self
    {
        $new = clone $this;
        $new->error = null;
        return $new;
    }

    /**
     * Disabled hint field part.
     *
     * @return static
     */
    public function withoutHint(): self
    {
        $new = clone $this;
        $new->hint = null;
        return $new;
    }

    /**
     * Disabled label field part.
     *
     * @return static
     */
    public function withoutLabel(): self
    {
        $new = clone $this;
        $new->label = null;
        return $new;
    }

    /**
     * Disabled label for attribute.
     * @return static
     */
    public function withoutLabelFor(): self
    {
        $new = clone $this;
        $new->labelAttributes['for'] = null;
        return $new;
    }
}
