<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yii\Extension\Simple\Model\FormModelInterface;
use Yii\Extension\Simple\Model\Helper\HtmlForm;
use Yii\Extension\Simple\Model\Helper\HtmlFormErrors;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

abstract class AbstractWidget extends Widget
{
    protected array $attributes = [];
    private string $attribute = '';
    private bool $encode = false;
    private string $id = '';
    private ?FormModelInterface $formModel = null;

    public function addClass(string $class): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, $class);
        return $new;
    }

    /**
     * Set aria-describedby attribute.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/WCAG20-TECHS/ARIA1.html
     */
    public function ariaDescribedBy(string $value): self
    {
        $new = clone $this;
        $new->attributes['aria-describedby'] = $value;
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
        $new->attributes = $values;
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
    public function for(FormModelInterface $formModel, string $attribute): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = $attribute;
        return $new;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute(): string
    {
        if ($this->attribute === '') {
            throw new InvalidArgumentException('Attribute is not set.');
        }

        return $this->attribute;
    }

    public function getAttributeHint(): string
    {
        return HtmlForm::getAttributeHint($this->getFormModel(), $this->getAttribute());
    }

    public function getAttributeLabel(): string
    {
        return HtmlForm::getAttributeLabel($this->getFormModel(), $this->getAttribute());
    }

    public function getAttributePlaceHolder(): string
    {
        return HtmlForm::getAttributePlaceHolder($this->getFormModel(), $this->getAttribute());
    }

    public function getFirstError(): string
    {
        return HtmlFormErrors::getFirstError($this->getFormModel(), $this->getAttribute());
    }

    public function hasError(): bool
    {
        return HtmlFormErrors::hasErrors($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Return FormModelInterface object.
     *
     * @return FormModelInterface
     */
    public function getFormModel(): FormModelInterface
    {
        if ($this->formModel === null) {
            throw new InvalidArgumentException('Form model is not set.');
        }

        return $this->formModel;
    }

    public function getInputId(): string
    {
        return HtmlForm::getInputId($this->getFormModel(), $this->getAttribute());
    }

    public function getInputName(): string
    {
        return HtmlForm::getInputName($this->getFormModel(), $this->getAttribute());
    }

    /**
     * The id content attribute is a unique identifier for the element.
     *
     * @param string $value the id attribute value.
     *
     * @return static
     */
    public function id(string $value): self
    {
        $new = clone $this;
        $new->attributes['id'] = $value;
        return $new;
    }

    public function isValidated(): bool
    {
        return $this->getFormModel()->isValidated();
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
     * It allows defining placeholder.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#the-placeholder-attribute
     */
    public function placeholder(string $value): self
    {
        $new = clone $this;
        $new->attributes['placeholder'] = $value;
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
     * The value obtained by the form model
     *
     * @param array|object|string|bool|int|float|null $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-value
     */
    public function value(array|object|string|bool|int|float|null $value): self
    {
        $new = clone $this;
        $new->attributes['value'] = $value;
        return $new;
    }

    public function getEncode(): bool
    {
        return $this->encode;
    }

    protected function getId(): string
    {
        return $this->id;
    }

    protected function getAttributeValue(): array|object|string|bool|int|float|null
    {
        return HtmlForm::getAttributeValue($this->getFormModel(), $this->getAttribute());
    }
}
