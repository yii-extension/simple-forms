<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input;

use function in_array;

/**
 * Generates an text input tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text
 */
final class TextInput extends Widget
{
    private string $invalidCssClass = '';
    private string $validCssClass = '';

    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        if (empty($new->modelInterface) || empty($new->attribute)) {
            throw new InvalidArgumentException(
                'The widget must be configured with FormInterface::class and Attribute.',
            );
        }

        $id = $new->getId($new->modelInterface->getFormName(), $new->attribute);

        if ($id !== '') {
            $new->attributes['id'] = $id;
        }

        if ($new->getNoPlaceholder() === false) {
            $new->setPlaceholder();
        }

        $new = $new->addHtmlValidation();
        $name = $new->getInputName($new->modelInterface->getFormName(), $new->attribute);
        $value = $new->modelInterface->getAttributeValue($new->getAttributeName($new->attribute));

        if (empty($new->modelInterface->getError($new->attribute)) && !empty($value)) {
            $new->validCssClass === '' ?: Html::addCssClass($new->attributes, $new->validCssClass);
        }

        if ($new->modelInterface->getError($new->attribute)) {
            $new->invalidCssClass === '' ?: Html::addCssClass($new->attributes, $new->invalidCssClass);
        }

        if (!is_scalar($value)) {
            throw new InvalidArgumentException('The value must be a bool|float|int|string|Stringable|null.');
        }

        return Input::text()->attributes($new->attributes)->name($name)->value($value)->render();
    }

    /**
     * Specifies whether the element represents an input control for which a UA is meant to store the value entered by
     * the user (so that the UA can prefill the form later).
     *
     * @param string $value The value must be `on`,` off`.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.autocomplete
     */
    public function autocomplete(string $value = 'on'): self
    {
        if ($value !== 'on' && $value !== 'off') {
            throw new InvalidArgumentException('The value must be `on`,` off`.');
        }

        $new = clone $this;
        $new->attributes['autocomplete'] = $value;
        return $new;
    }

    public function invalidCssClass(string $value): self
    {
        $new = clone $this;
        $new->invalidCssClass = $value;
        return $new;
    }

    /**
     * The maxlength attribute defines the maximum number of characters (as UTF-16 code units) the user can enter into
     * an tag input.
     *
     * If no maxlength is specified, or an invalid value is specified, the tag input has no maximum length.
     *
     * @param int $value Positive integer.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.maxlength
     */
    public function maxlength(int $value): self
    {
        $new = clone $this;
        $new->attributes['maxlength'] = $new->validateIntegerPositive($value);
        return $new;
    }

    /**
     * Set custom error message when an input field is invalid.
     *
     * @param string $message
     *
     * @return static
     */
    public function onInvalid(string $message): self
    {
        $new = clone $this;
        $new->attributes['oninvalid'] = "this.setCustomValidity('$message')";
        return $new;
    }

    /**
     * A Boolean attribute which, if present, means this field cannot be edited by the user.
     * Its value can, however, still be changed by JavaScript code directly setting the HTMLInputElement.value
     * property.
     *
     * @param bool $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.readonly
     */
    public function readonly(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['readonly'] = $value;
        return $new;
    }

    /**
     * The number of options meant to be shown by the control represented by its element.
     *
     * @param int $value Positive integer.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.size
     */
    public function size(int $value): self
    {
        $new = clone $this;
        $new->attributes['size'] = $new->validateIntegerPositive($value);
        return $new;
    }

    public function validCssClass(string $value): self
    {
        $new = clone $this;
        $new->validCssClass = $value;
        return $new;
    }

    private function setPlaceholder(): void
    {
        if (!isset($this->attributes['placeholder'])) {
            $attributeName = $this->getAttributeName($this->attribute);
            $this->attributes['placeholder'] = $this->modelInterface->getAttributeLabel($attributeName);
        }
    }
}
