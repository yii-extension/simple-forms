<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Attribute;

use InvalidArgumentException;
use UnexpectedValueException;
use Yii\Extension\Form\Exception\AttributeNotSetException;
use Yii\Extension\Form\Exception\FormModelNotSetException;
use Yii\Extension\FormModel\Attribute\FormModelAttributes;
use Yii\Extension\FormModel\Contract\FormModelContract;

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
        return FormModelAttributes::getInputId($this->getFormModel(), $this->getAttribute());
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

    /**
     * This method parses an attribute expression and returns an associative array containing
     * real attribute name, prefix and suffix.
     * For example: `['name' => 'content', 'prefix' => '', 'suffix' => '[0]']`
     *
     * An attribute expression is an attribute name prefixed and/or suffixed with array indexes. It is mainly used in
     * tabular data input and/or input of array type. Below are some examples:
     *
     * - `[0]content` is used in tabular data input to represent the "content" attribute for the first model in tabular
     *    input;
     * - `dates[0]` represents the first array element of the "dates" attribute;
     * - `[0]dates[0]` represents the first array element of the "dates" attribute for the first model in tabular
     *    input.
     *
     * @param string $attribute the attribute name or expression
     *
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     *
     * @return string[] the attribute name, prefix and suffix.
     */
    private function parseAttribute(string $attribute): array
    {
        if (!preg_match('/(^|.*\])([\w\.\+\-_]+)(\[.*|$)/u', $attribute, $matches)) {
            throw new InvalidArgumentException('Attribute name must contain word characters only.');
        }

        return ['name' => $matches[2], 'prefix' => $matches[1], 'suffix' => $matches[3]];
    }
}
