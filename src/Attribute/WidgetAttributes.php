<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Attribute;

use InvalidArgumentException;
use Yii\Extension\Simple\Model\FormModelInterface;
use Yii\Extension\Simple\Model\Helper\HtmlForm;
use Yii\Extension\Simple\Model\Helper\HtmlFormErrors;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

abstract class WidgetAttributes extends Widget
{
    protected array $attributes = [];
    protected bool $encode = false;
    private string $attribute = '';
    private ?FormModelInterface $formModel = null;

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
     * Set form model and attribute widget.
     *
     * @return static
     */
    public function for(FormModelInterface $formModel, string $attribute): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = $attribute;
        return $new;
    }

    /**
     * Return attribute field.
     *
     * @return string
     */
    public function getAttribute(): string
    {
        if ($this->attribute === '') {
            throw new InvalidArgumentException('Attribute is not set.');
        }

        return $this->attribute;
    }

    /**
     * Return attributes for the widget.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Generate hint attribute.
     *
     * @return string
     */
    public function getAttributeHint(): string
    {
        return HtmlForm::getAttributeHint($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Generate label attribute.
     *
     * @return string
     */
    public function getAttributeLabel(): string
    {
        return HtmlForm::getAttributeLabel($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Generate placeholder attribute.
     *
     * @return string
     */
    public function getAttributePlaceHolder(): string
    {
        return HtmlForm::getAttributePlaceHolder($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Return first error message for the attribute.
     *
     * @return string
     */
    public function getFirstError(): string
    {
        return HtmlFormErrors::getFirstError($this->getFormModel(), $this->getAttribute());
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

    /**
     * Generate input id attribute.
     */
    public function getInputId(): string
    {
        return HtmlForm::getInputId($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Generate input name attribute.
     *
     * @return string
     */
    public function getInputName(): string
    {
        return HtmlForm::getInputName($this->getFormModel(), $this->getAttribute());
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
        Html::addCssClass($new->attributes, $class);
        return $new;
    }

    /**
     * Return if there is a validation error in the attribute.
     */
    public function hasError(): bool
    {
        return HtmlFormErrors::hasErrors($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Return if the field was validated.
     *
     * @return bool
     */
    public function isValidated(): bool
    {
        return $this->getFormModel()->isValidated();
    }

    /**
     * Return value of attribute.
     *
     * @return array|object|string|bool|int|float|null
     */
    protected function getAttributeValue()
    {
        return HtmlForm::getAttributeValue($this->getFormModel(), $this->getAttribute());
    }
}
