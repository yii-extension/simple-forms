<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yii\Extension\Simple\Forms\Attribute\GlobalAttributes;
use Yii\Extension\Simple\Model\FormModelInterface;
use Yii\Extension\Simple\Model\Helper\HtmlForm;
use Yii\Extension\Simple\Model\Helper\HtmlFormErrors;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

abstract class AbstractWidget extends GlobalAttributes
{
    private string $attribute = '';
    private ?string $containerClass = null;
    private ?FormModelInterface $formModel = null;
    private string $id = '';
    private string $inputClass = '';
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

    public function containerClass(string $value): self
    {
        $new = clone $this;
        $new->containerClass = $value;
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

    public function getAttributePlaceHolder(): string
    {
        return HtmlForm::getAttributePlaceHolder($this->getFormModel(), $this->getAttribute());
    }

    public function getContainerClass(): ?string
    {
        return $this->containerClass;
    }

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

    public function getInputClass(): string
    {
        /** @var string */
        $inputClass = $this->attributes['class'] ?? '';
        return $inputClass;
    }

    public function getInputId(): string
    {
        return HtmlForm::getInputId($this->getFormModel(), $this->getAttribute());
    }

    public function getInputName(): string
    {
        return HtmlForm::getInputName($this->getFormModel(), $this->getAttribute());
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function hasError(): bool
    {
        return HtmlFormErrors::hasErrors($this->getFormModel(), $this->getAttribute());
    }

    public function inputClass(string $class): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, $class);
        return $new;
    }

    public function isValidated(): bool
    {
        return $this->getFormModel()->isValidated();
    }

    public function template(string $template): self
    {
        $new = clone $this;
        $new->template = $template;
        return $new;
    }

    /**
     * @return array|object|string|bool|int|float|null
     */
    protected function getAttributeValue()
    {
        return HtmlForm::getAttributeValue($this->getFormModel(), $this->getAttribute());
    }
}
