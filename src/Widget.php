<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yii\Extension\Simple\Forms\Attribute\GlobalAttributes;
use Yii\Extension\Simple\Model\FormModelInterface;
use Yii\Extension\Simple\Model\Helper\HtmlForm;
use Yii\Extension\Simple\Model\Helper\HtmlFormErrors;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget as BaseWidget;

abstract class Widget extends BaseWidget
{
    use GlobalAttributes;

    protected bool $encode = false;
    private string $attribute = '';
    private ?FormModelInterface $formModel = null;

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
     * Return value of attribute.
     *
     * @return array|object|string|bool|int|float|null
     */
    protected function getAttributeValue()
    {
        return HtmlForm::getAttributeValue($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Return if there is a validation error in the attribute.
     */
    protected function hasError(): bool
    {
        return HtmlFormErrors::hasErrors($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Return if the field was validated.
     *
     * @return bool
     */
    protected function isValidated(): bool
    {
        return $this->getFormModel()->isValidated();
    }
}
