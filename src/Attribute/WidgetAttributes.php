<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Attribute;

use InvalidArgumentException;
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
        $new->charset = $charset;
        return $new;
    }

    public function for(FormModelContract $formModel, string $attribute): static
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = match ($new->getFormModel()->has($attribute)) {
            true => $attribute,
            false => throw new AttributeNotSetException($attribute),
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

    /**
     * Generates an appropriate input ID for the specified attribute name or expression.
     *
     * This method converts the result {@see getInputName()} into a valid input ID.
     *
     * For example, if {@see getInputName()} returns `Post[content]`, this method will return `post-content`.
     *
     * @param FormModelContract $formModel the form object
     * @param string $attribute the attribute name or expression. See {@see getAttributeName()} for explanation of
     * attribute expression.
     * @param string $charset default `UTF-8`.
     *
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     * @throws UnexpectedValueException if charset is unknown
     *
     * @return string the generated input ID.
     */
    protected function getInputId(): string
    {
        $attribute = $this->getAttribute();
        $formModel = $this->getFormModel();
        $name = mb_strtolower($this->getInputName($formModel, $attribute), $this->charset);
        return str_replace(['[]', '][', '[', ']', ' ', '.'], ['', '-', '-', '', '-', '-'], $name);
    }

    /**
     * Generates an appropriate input name for the specified attribute name or expression.
     *
     * This method generates a name that can be used as the input name to collect user input for the specified
     * attribute. The name is generated according to the of the form and the given attribute name. For example, if the
     * form name of the `Post` form is `Post`, then the input name generated for the `content` attribute would be
     * `Post[content]`.
     *
     * See {@see getAttributeName()} for explanation of attribute expression.
     *
     * @param FormModelContract $formModel the form object.
     * @param string $attribute the attribute name or expression.
     *
     * @throws InvalidArgumentException if the attribute name contains non-word characters
     * or empty form name for tabular inputs
     *
     * @return string the generated input name.
     */
    protected function getInputName(): string
    {
        $attribute = $this->getAttribute();
        $data = $this->parseAttribute($attribute);
        $formModel = $this->getFormModel();
        $formName = $formModel->getFormName();

        if ($formName === '' && $data['prefix'] === '') {
            return $attribute;
        }

        if ($formName !== '') {
            return "$formName{$data['prefix']}[{$data['name']}]{$data['suffix']}";
        }

        throw new InvalidArgumentException('formName() cannot be empty for tabular inputs.');
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
