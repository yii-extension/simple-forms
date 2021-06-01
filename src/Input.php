<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Html\Html;

use function in_array;

final class Input extends Widget
{
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
    private string $id = '';
    private bool $noPlaceholder = false;
    private string $type = 'text';

    /**
     * Generates an input tag for the given form attribute.
     *
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        if (empty($new->formModel) || empty($new->attribute)) {
            throw new InvalidArgumentException(
                'The widget must be configured with FormModelInterface::class and Attribute.',
            );
        }

        if ($new->noPlaceholder === false) {
            $new->setPlaceholder();
        }

        $id = $new->getId($new->formModel->getFormName(), $new->attribute);

        if ($id !== '') {
            $new->attributes['id'] = $new->getId($new->formModel->getFormName(), $new->attribute);
        }

        return
            Html::input(
                $new->type,
                $new->getInputName($new->formModel->getFormName(), $new->attribute),
                $new->formModel->getAttributeValue($new->getAttributeName($new->attribute)),
            )->attributes($new->attributes)->render();
    }

    /**
     * Focus on the control (put cursor into it) when the page loads.
     * Only one form element could be in focus at the same time.
     *
     * It cannot be applied if the type attribute has a hidden value (that is, you cannot automatically set the cursor
     * to a hidden control).
     *
     * @return static
     */
    public function autofocus(): self
    {
        $new = clone $this;
        $new->attributes['autofocus'] = true;
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
     */
    public function form(string $value): self
    {
        $new = clone $this;
        $new->attributes['form'] = $value;
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
     */
    public function required(): self
    {
        $new = clone $this;
        $new->attributes['required'] = true;
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

    private function setPlaceholder(): void
    {
        if (
            !isset($this->attributes['placeholder']) &&
            !(in_array($this->type, ['date', 'file', 'hidden', 'color'], true))
        ) {
            $attributeName = $this->getAttributeName($this->attribute);

            if ($this->formModel !== null) {
                $this->attributes['placeholder'] = $this->formModel->getAttributeLabel($attributeName);
            }
        }
    }
}
