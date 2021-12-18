<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yii\Extension\Simple\Forms\Attribute\GlobalAttributes;
use Yii\Extension\Simple\Forms\Validator\FieldValidator;
use Yii\Extension\Simple\Model\FormModelInterface;
use Yii\Extension\Simple\Model\Helper\HtmlForm;
use Yii\Extension\Simple\Model\Helper\HtmlFormErrors;
use Yiisoft\Html\Html;

abstract class AbstractWidget extends GlobalAttributes
{
    private string $attribute = '';
    private ?string $containerClass = null;
    private ?FormModelInterface $formModel = null;
    private ?string $template = null;

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
     * Return attributes for the widget.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
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
     * Return aria-describedby attribute.
     *
     * @return string
     */
    public function getAriaDescribedBy(): string
    {
        /** @var string */
        return $this->attributes['aria-describedby'] ?? '';
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
     * Return if there is a validation error in the attribute.
     */
    public function hasError(): bool
    {
        return HtmlFormErrors::hasErrors($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Set CSS class of the field widget.
     *
     * @param string $value
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
     * Return if the field was validated.
     *
     * @return bool
     */
    public function isValidated(): bool
    {
        return $this->getFormModel()->isValidated();
    }

    /**
     * Set template for field widget.
     *
     * @param string $template
     *
     * @return static
     */
    public function template(string $template): self
    {
        $new = clone $this;
        $new->template = $template;
        return $new;
    }

    /**
     * Set build attributes for the widget.
     *
     * @param array|object|string|bool|int|float|null $value
     *
     * @return self
     */
    protected function build($value): self
    {
        $new = clone $this;

        $fieldValidator = new FieldValidator();

        $new = $new->setId($new->getInputId());
        $new = $new->setName($new->getInputName());
        $new = $new->setValue($value);
        $new = $fieldValidator->getValidatorAttributes($new);

        return $new;
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
