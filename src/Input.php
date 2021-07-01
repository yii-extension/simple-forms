<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input as InputHtml;

use function in_array;

/**
 * A widget for rendering a input form.
 */
final class Input extends Widget
{
    public const EXCLUDE_PLACEHOLDER = [
        self::TYPE_COLOR,
        self::TYPE_DATE,
        self::TYPE_FILE,
        self::TYPE_HIDDEN,
    ];
    public const TYPE_BUTTON = 'button';
    public const TYPE_CHECKBOX = 'checkbox';
    public const TYPE_COLOR = 'color';
    public const TYPE_DATE = 'date';
    public const TYPE_DATETIME_LOCAL = 'datetime-local';
    public const TYPE_EMAIL = 'email';
    public const TYPE_FILE = 'file';
    public const TYPE_HIDDEN = 'hidden';
    public const TYPE_IMAGE = 'image';
    public const TYPE_MONTH = 'month';
    public const TYPE_NUMBER = 'number';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_RADIO = 'radio';
    public const TYPE_RANGE = 'range';
    public const TYPE_RESET = 'reset';
    public const TYPE_SEARCH = 'search';
    public const TYPE_SUBMIT = 'submit';
    public const TYPE_TEL = 'tel';
    public const TYPE_TEXT = 'text';
    public const TYPE_TIME = 'time';
    public const TYPE_URL = 'url';
    public const TYPE_WEEK = 'week';
    public const TYPE_ALL = [
        self::TYPE_BUTTON,
        self::TYPE_CHECKBOX,
        self::TYPE_COLOR,
        self::TYPE_DATE,
        self::TYPE_DATETIME_LOCAL,
        self::TYPE_EMAIL,
        self::TYPE_FILE,
        self::TYPE_HIDDEN,
        self::TYPE_IMAGE,
        self::TYPE_MONTH,
        self::TYPE_NUMBER,
        self::TYPE_PASSWORD,
        self::TYPE_RADIO,
        self::TYPE_RANGE,
        self::TYPE_RESET,
        self::TYPE_SEARCH,
        self::TYPE_SUBMIT,
        self::TYPE_TEL,
        self::TYPE_TEXT,
        self::TYPE_TIME,
        self::TYPE_URL,
        self::TYPE_WEEK,
    ];
    private string $invalidCssClass = '';
    private string $type = 'text';
    private string $validCssClass = '';

    /**
     * Generates an input tag for the given form attribute.
     *
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
            $new->attributes['id'] = $new->getId($new->modelInterface->getFormName(), $new->attribute);
        }

        if ($new->getNoPlaceholder() === false) {
            $new->setPlaceholder();
        }

        $new = $new->addHtmlValidation();
        $name = $new->getInputName($new->modelInterface->getFormName(), $new->attribute);
        $value = $new->modelInterface->getAttributeValue($new->getAttributeName($new->attribute));

        if (empty($new->modelInterface->getError($new->attribute)) && !empty($value)) {
            Html::addCssClass($new->attributes, $new->validCssClass);
        }

        if ($new->modelInterface->getError($new->attribute)) {
            Html::addCssClass($new->attributes, $new->invalidCssClass);
        }

        return InputHtml::tag()->attributes($new->attributes)->name($name)->type($new->type)->value($value)->render();
    }

    public function invalidCssClass(string $value): self
    {
        $new = clone $this;
        $new->invalidCssClass = $value;
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
     * Type of the input control to use.
     *
     * @param string $value
     *
     * @return self
     */
    public function type(string $value): self
    {
        if (!in_array($value, self::TYPE_ALL)) {
            $values = implode('", "', self::TYPE_ALL);
            throw new InvalidArgumentException("Invalid type. Valid values are: \"$values\".");
        }

        $new = clone $this;
        $new->type = $value;
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
        if (!isset($this->attributes['placeholder']) && !(in_array($this->type, self::EXCLUDE_PLACEHOLDER, true))) {
            $attributeName = $this->getAttributeName($this->attribute);

            $this->attributes['placeholder'] = $this->modelInterface->getAttributeLabel($attributeName);
        }
    }
}
