<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Attribute;

use InvalidArgumentException;
use UnexpectedValueException;
use Yii\Extension\Form\Exception\AttributeNotSetException;
use Yii\Extension\Form\Exception\FormModelNotSetException;
use Yii\Extension\Model\Attribute\FormModelAttributes;
use Yii\Extension\Model\Contract\FormModelContract;

use function mb_strtolower;
use function str_replace;

abstract class WidgetAttributes extends GlobalAttributes
{
    private string $attribute = '';
    private string $charset = 'UTF-8';
    private ?FormModelContract $formModel = null;

    public function charset(string $value): self
    {
        $new = clone $this;
        $new->charset = $value;
        return $new;
    }

    public function for(FormModelContract $formModel, string $attribute): static
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = match ($new->getFormModel()->has($attribute)) {
            true => $attribute,
            false => throw new AttributeNotSetException(),
        };
        return $new;
    }

    protected function getAttribute(): string
    {
        return $this->attribute;
    }

    /**
     * Return FormModelContract object.
     *
     * @return FormModelContract
     */
    protected function getFormModel(): FormModelContract
    {
        return match (empty($this->formModel)) {
            true => throw new FormModelNotSetException(),
            false => $this->formModel,
        };
    }

    protected function getInputId(): string
    {
        return FormModelAttributes::getInputId($this->getFormModel(), $this->getAttribute(), $this->charset);
    }

    protected function getInputName(): string
    {
        return FormModelAttributes::getInputName($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Generate label attribute.
     *
     * @return string
     */
    protected function getLabel(): string
    {
        return FormModelAttributes::getLabel($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Generate placeholder attribute.
     *
     * @return string
     */
    protected function getPlaceHolder(): string
    {
        return FormModelAttributes::getPlaceHolder($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Return value of attribute.
     *
     * @return mixed
     */
    protected function getValue(): mixed
    {
        return FormModelAttributes::getValue($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Return if there is a validation error in the attribute.
     *
     * @return bool
     */
    protected function hasError(): bool
    {
        return $this->getFormModel()->error()->has($this->getAttribute());
    }

    /**
     * Return if the form is empty.
     */
    protected function isValidated(): bool
    {
        return !$this->isEmpty() && !$this->hasError();
    }

    /**
     * Return if the form is empty.
     */
    private function isEmpty(): bool
    {
        return $this->getFormModel()->isEmpty();
    }
}
