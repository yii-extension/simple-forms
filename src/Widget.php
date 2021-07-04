<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Stringable;
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
    private bool $noPlaceholder = false;

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
     * Focus on the control (put cursor into it) when the page loads.
     * Only one form element could be in focus at the same time.
     *
     * It cannot be applied if the type attribute is "hidden" (that is, you cannot automatically set the cursor
     * to a hidden control).
     *
     * @param bool $value
     *
     * @return static
     *
     * @link https://www.w3.org/Submission/web-forms2/#the-autofocus
     */
    public function autofocus(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['autofocus'] = $value;
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
     *
     * @return static
     *
     * See {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function config(ModelInterface $modelInterface, string $attribute): self
    {
        $new = clone $this;
        $new->modelInterface = $modelInterface;
        $new->attribute = $attribute;
        return $new;
    }

    /**
     * Set whether the element is disabled or not.
     *
     * If this attribute is set to `true`, the element is disabled. Disabled elements are usually drawn with grayed-out
     * text.
     *
     * If the element is disabled, it does not respond to user actions, it cannot be focused, and the command event
     * will not fire. In the case of form elements, it will not be submitted. Do not set the attribute to true, as
     * this will suggest you can set it to false to enable the element again, which is not the case.
     *
     * @return static
     *
     * @link https://www.w3.org/Submission/web-forms2/#disabled
     */
    public function disabled(): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = true;
        return $new;
    }

    /**
     * Specifies the form element the tag input element belongs to. The value of this attribute must be the id attribute
     * of a {@see Form} element in the same document.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-formelements-form
     */
    public function form(string $value): self
    {
        $new = clone $this;
        $new->attributes['form'] = $value;
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
     * Allows you to disable placeholder.
     *
     * @return static
     */
    public function noPlaceholder(): self
    {
        $new = clone $this;
        $new->noPlaceholder = true;
        return $new;
    }

    /**
     * It allows defining placeholder.
     *
     * @param string $value
     *
     * @return static
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
     * @link https://www.w3.org/Submission/web-forms2/#required
     */
    public function required(): self
    {
        $new = clone $this;
        $new->attributes['required'] = true;
        return $new;
    }

    /**
     * Spellcheck is a global attribute which is used to indicate whether or not to enable spell checking for an
     * element.
     *
     * @param bool $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/global-attributes.html#common.attrs.spellcheck
     */
    public function spellcheck(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['spellcheck'] = $value;
        return $new;
    }

    /**
     * The tabindex global attribute indicates that its element can be focused, and where it participates in sequential
     * keyboard navigation (usually with the Tab key, hence the name).
     *
     * It accepts an integer as a value, with different results depending on the integer's value:
     *
     * - A negative value (usually tabindex="-1") means that the element is not reachable via sequential keyboard
     * navigation, but could be focused with Javascript or visually. It's mostly useful to create accessible widgets
     * with JavaScript.
     * - tabindex="0" means that the element should be focusable in sequential keyboard navigation, but its order is
     * defined by the document's source order.
     * - A positive value means the element should be focusable in sequential keyboard navigation, with its order
     * defined by the value of the number. That is, tabindex="4" is focused before tabindex="5", but after tabindex="3".
     *
     * @param int $value
     *
     * @return static
     */
    public function tabIndex(int $value = 0): self
    {
        $new = clone $this;
        $new->attributes['tabindex'] = $value;
        return $new;
    }

    /**
     * The title global attribute contains text representing advisory information related to the element it belongs to.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/global-attributes.html#common.attrs.title
     */
    public function title(string $value): self
    {
        $new = clone $this;
        $new->attributes['title'] = $value;
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

    protected function getFirstError(): string
    {
        return $this->modelInterface->getFirstError($this->getAttributeName());
    }

    protected function getId(): string
    {
        $new = clone $this;

        /** @var string */
        $id = $new->attributes['id'] ?? $new->id;

        return $id === '' ? $new->getInputId() : $id;
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
        $name = mb_strtolower($this->getInputName(), $this->charset);
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
     * @throws InvalidArgumentException if the attribute name contains non-word characters or empty form name for
     * tabular inputs.
     *
     * @return string the generated input name.
     */
    protected function getInputName(): string
    {
        $new = clone $this;

        $data = $new->parseAttribute();

        return $new->getFormName() . $data['prefix'] . '[' . $data['name'] . ']' . $data['suffix'];
    }

    private function getFormName(): string
    {
        return $this->modelInterface->getFormName();
    }

    protected function getLabel(): string
    {
        return $this->modelInterface->getAttributeLabel($this->getAttributeName());
    }

    protected function getNoPlaceHolder(): bool
    {
        return $this->noPlaceholder;
    }

    /**
     * @return null|scalar|Stringable|iterable
     */
    protected function getValue()
    {
        return $this->modelInterface->getAttributeValue($this->getAttributeName());
    }

    protected function setPlaceholder(): void
    {
        if (!isset($this->attributes['placeholder'])) {
            $this->attributes['placeholder'] = $this->getLabel();
        }
    }

    protected function validateConfig(): void
    {
        if (empty($this->modelInterface) || empty($this->attribute)) {
            throw new InvalidArgumentException(
                'The widget must be configured with FormInterface::class and Attribute.',
            );
        }
    }

    protected function validateIntegerPositive(int $value): int
    {
        if ($value < 0) {
            throw new InvalidArgumentException('The value must be a positive integer.');
        }

        return $value;
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
        if (!preg_match('/(^|.*\])([\w\.\+]+)(\[.*|$)/u', $this->attribute, $matches)) {
            throw new InvalidArgumentException('Attribute name must contain word characters only.');
        }

        return [
            'name' => $matches[2],
            'prefix' => $matches[1],
            'suffix' => $matches[3],
        ];
    }
}
