<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use UnexpectedValueException;
use Yii\Extension\Simple\Model\ModelInterface;
use Yii\Extension\Simple\Widget\AbstractWidget;
use Yiisoft\Html\NoEncodeStringableInterface;
use Yiisoft\Validator\Rule\Required;

abstract class Widget extends AbstractWidget implements NoEncodeStringableInterface
{
    protected string $attribute = '';
    protected array $attributes = [];
    protected ModelInterface $modelInterface;
    private bool $autoGenerate = true;
    private string $charset = 'UTF-8';
    private string $id = '';

    /**
     * The HTML attributes for the navbar. The following special options are recognized.
     *
     * @param array $value
     *
     * @return static
     */
    public function attributes(array $value): self
    {
        $new = clone $this;
        $new->attributes = $value;
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
     * Set form interface, attribute name and attributes for the widget.
     *
     * @param ModelInterface $modelInterface Form.
     * @param string $attribute Form model property this widget is rendered for.
     * @param array $attributes The HTML attributes for the widget container tag.
     *
     * @return static
     *
     * See {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function config(ModelInterface $modelInterface, string $attribute, array $attributes = []): self
    {
        $new = clone $this;
        $new->modelInterface = $modelInterface;
        $new->attribute = $attribute;
        $new->attributes = $attributes;
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
     * If it is required to fill in a value in order to submit the form.
     *
     * @return static
     */
    public function required(): self
    {
        $new = clone $this;
        $new->attributes['required'] = true;
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

        /** @var object $rule */
        foreach ($rules[$new->attribute] as $rule) {
            if ($rule instanceof Required) {
                $new = $new->required();
            }
        }
        return $new;
    }

    /**
     * Returns the real attribute name from the given attribute expression.
     * If `$attribute` has neither prefix nor suffix, it will be returned back without change.
     *
     * @param string $attribute the attribute name or expression
     *
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     *
     * @return string the attribute name without prefix and suffix.
     *
     * {@see parseAttribute()}
     */
    protected function getAttributeName(string $attribute): string
    {
        return (string) $this->parseAttribute($attribute)['name'];
    }

    protected function getCharset(): string
    {
        return $this->charset;
    }

    protected function getId(string $formName, string $attribute): string
    {
        $new = clone $this;

        /** @var string */
        $id = $new->attributes['id'] ?? $new->id;

        if ($id === '') {
            $id = $new->getInputId($formName, $attribute, $new->charset);
        }

        return $id;
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
     * @param string $formName the formname.
     * @param string $attribute the attribute name or expression.
     *
     * @throws InvalidArgumentException if the attribute name contains non-word characters or empty form name for
     * tabular inputs.
     *
     * @return string the generated input name.
     */
    protected function getInputName(string $formName, string $attribute): string
    {
        $data = $this->parseAttribute($attribute);

        if ($formName === '' && $data['prefix'] === '') {
            return $attribute;
        }

        if ($formName !== '') {
            return $formName . (string) $data['prefix'] . '[' . (string) $data['name'] . ']' . (string) $data['suffix'];
        }

        throw new InvalidArgumentException('The formName cannot be empty.');
    }

    /**
     * Generates an appropriate input ID for the specified attribute name or expression.
     *
     * This method converts the result {@see getInputName()} into a valid input ID.
     *
     * For example, if {@see getInputName()} returns `Post[content]`, this method will return `post-content`.
     *
     * @param string $form the formname
     * @param string $attribute the attribute name or expression. See {@see getAttributeName()} for explanation of
     * attribute expression.
     * @param string $charset default `UTF-8`.
     *
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     * @throws UnexpectedValueException if charset is unknown
     *
     * @return string the generated input ID.
     */
    private function getInputId(string $formName, string $attribute, string $charset = 'UTF-8'): string
    {
        $name = mb_strtolower($this->getInputName($formName, $attribute), $charset);
        return str_replace(['[]', '][', '[', ']', ' ', '.'], ['', '-', '-', '', '-', '-'], $name);
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
     * @param string $attribute the attribute name or expression.
     *
     * @return array
     *
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     */
    private function parseAttribute(string $attribute): array
    {
        if (!preg_match('/(^|.*\])([\w\.\+]+)(\[.*|$)/u', $attribute, $matches)) {
            throw new InvalidArgumentException('Attribute name must contain word characters only.');
        }

        return [
            'name' => $matches[2],
            'prefix' => $matches[1],
            'suffix' => $matches[3],
        ];
    }
}
