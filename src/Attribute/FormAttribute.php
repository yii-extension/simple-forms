<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Attribute;

use InvalidArgumentException;
use UnexpectedValueException;
use Yii\Extension\Simple\Model\ModelInterface;
use Yiisoft\Validator\Rule\Required;

abstract class FormAttribute extends Attributes
{
    private string $attribute = '';
    private string $charset = 'UTF-8';
    private string $id = '';
    private ModelInterface $modelInterface;

    /**
     * Set form interface, attribute name and attributes for the widget.
     *
     * @param ModelInterface $modelInterface Form.
     * @param string $attribute Form model property this widget is rendered for.
     *
     * @return static
     */
    public function config(ModelInterface $modelInterface, string $attribute): self
    {
        $new = clone $this;
        $new->modelInterface = $modelInterface;
        $new->attribute = $attribute;
        return $new;
    }

    /**
     * Set the character set used to generate the widget id. See {@see HtmlForm::getInputId()}.
     *
     * @param string $value
     *
     * @return static
     */
    public function charset(string $value): self
    {
        $new = clone $this;
        $new->charset = $value;
        return $new;
    }

    /**
     * Set the Id of the widget.
     *
     * @param string $value
     *
     * @return static
     */
    public function id(string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    /**
     * @return static
     */
    protected function addHtmlValidation(): self
    {
        $new = clone $this;

        /** @var array */
        $rules = $new->modelInterface->getRules();

        /** @var array */
        $rulesAttributes = $rules[$new->attribute] ?? [];

        /** @var object $rule */
        foreach ($rulesAttributes as $rule) {
            if ($rule instanceof Required) {
                $new = $new->required();
            }
        }

        return $new;
    }

    protected function beforeRun(): bool
    {
        if (empty($this->modelInterface) || empty($this->attribute)) {
            throw new InvalidArgumentException(
                'The widget must be configured with FormInterface::class and Attribute.',
            );
        }

        return true; // or false to not run the widget
    }

    /**
     * Return the attribute first error message.
     *
     * @return string
     */
    protected function getFirstError(): string
    {
        return $this->modelInterface->getFirstError($this->getAttributeName());
    }

    /**
     * Return true if attribute has errors, false otherwise.
     *
     * @return bool
     */
    protected function hasErrors(): bool
    {
        return $this->modelInterface->hasErrors($this->getAttributeName());
    }

    /**
     * Return the attribute model.
     *
     * @return string
     */
    protected function getAttribute(): string
    {
        return $this->attribute;
    }

    /**
     * Return the attribute hint.
     *
     * @return string
     */
    protected function getAttributeHint(): string
    {
        return $this->modelInterface->getAttributeHint($this->getAttributeName());
    }

    /**
     * Return the imput id.
     *
     * @return string
     */
    protected function getId(): string
    {
        $new = clone $this;

        /** @var string */
        $id = $new->attributes['id'] ?? $new->id;

        return $id === '' ? $new->getInputId() : $id;
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
     * @throws InvalidArgumentException if the attribute name contains non-word characters or empty form name for
     * tabular inputs.
     *
     * @return string the generated input name.
     */
    protected function getInputName(): string
    {
        $new = clone $this;
        $data = $new->parseAttribute();
        return "{$new->modelInterface->getFormName()}{$data['prefix']}[{$data['name']}]{$data['suffix']}";
    }

    /**
     * Return the attribute label.
     *
     * @return string
     */
    protected function getLabel(): string
    {
        return $this->modelInterface->getAttributeLabel($this->getAttributeName());
    }

    /**
     * Return the model interface.
     *
     * @return ModelInterface
     */
    protected function getModelInterface(): ModelInterface
    {
        return $this->modelInterface;
    }

    /**
     * Return the attribute value.
     *
     * @return scalar|iterable|object|Stringable|null
     */
    protected function getValue()
    {
        return $this->modelInterface->getAttributeValue($this->getAttributeName());
    }

    /**
     * Returns the real attribute name from the given attribute expression.
     *
     * If `$attribute` has neither prefix nor suffix, it will be returned back without change.
     *
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     *
     * @return string the attribute name without prefix and suffix.
     *
     * {@see parseAttribute()}
     */
    private function getAttributeName(): string
    {
        return $this->parseAttribute()['name'];
    }

    /**
     * Set the attribute placeholder.
     */
    protected function setPlaceholder(): void
    {
        if (!isset($this->attributes['placeholder'])) {
            $this->attributes['placeholder'] = $this->getLabel();
        }
    }

    /**
     * Generates an appropriate input ID for the specified attribute name or expression.
     *
     * This method converts the result {@see getInputName()} into a valid input ID.
     *
     * For example, if {@see getInputName()} returns `Post[content]`, this method will return `post-content`.
     *
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     * @throws UnexpectedValueException if charset is unknown
     *
     * @return string the generated input ID.
     */
    private function getInputId(): string
    {
        $new = clone $this;
        $name = mb_strtolower($new->getInputName(), $new->charset);
        return str_replace(['[]', '][', '[', ']', ' ', '.'], ['', '-', '-', '', '-', '-'], $name);
    }

    /**
     * This method parses an attribute expression and returns an associative array containing real attribute name,
     * prefix and suffix.
     *
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
     * @return string[]
     *
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     */
    private function parseAttribute(): array
    {
        $new = clone $this;

        if (!preg_match('/(^|.*)([\w]+)(\[.*|$)/u', $new->attribute, $matches)) {
            throw new InvalidArgumentException('Attribute name must contain word characters only.');
        }

        return [
            'name' => $matches[2],
            'prefix' => $matches[1],
            'suffix' => $matches[3],
        ];
    }
}
