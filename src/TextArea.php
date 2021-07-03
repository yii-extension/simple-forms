<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Html\Tag\Textarea as TextAreaTag;

/**
 * Generates a textarea tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html
 */
final class TextArea extends Widget
{
    /**
     * @return string the generated textarea tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        if ($new->getNoPlaceholder() === false) {
            $new->setPlaceholder();
        }

        $id = $new->getId($new->modelInterface->getFormName(), $new->attribute);

        if ($id !== '') {
            $new->attributes['id'] = $new->getId($new->modelInterface->getFormName(), $new->attribute);
        }

        $name = $new->getInputName($new->modelInterface->getFormName(), $new->attribute);
        $value = $new->modelInterface->getAttributeValue($new->getAttributeName($new->attribute));

        if (!is_string($value)) {
            throw new InvalidArgumentException('The value must be a string|null.');
        }

        return TextAreaTag::tag()->attributes($new->attributes)->name($name)->value($value)->render();
    }

    /**
     * The expected maximum number of characters per line of text for the UA to show.
     *
     * @param int $value Positive integer.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.cols
     */
    public function cols(int $value): self
    {
        $new = clone $this;
        $new->attributes['cols'] = $new->validateIntegerPositive($value);
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
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.maxlength
     */
    public function maxlength(int $value): self
    {
        $new = clone $this;
        $new->attributes['maxlength'] = $new->validateIntegerPositive($value);
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
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.readonly
     */
    public function readonly(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['readonly'] = $value;
        return $new;
    }

    /**
     * The number of lines of text for the UA to show.
     *
     * @param int $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.rows
     */
    public function rows(int $value): self
    {
        $new = clone $this;
        $new->attributes['rows'] = $value;
        return $new;
    }

    /**
     * @param string $value Contains the hard and soft values.
     * `hard` Instructs the UA to insert line breaks into the submitted value of the textarea such that each line has no
     *  more characters than the value specified by the cols attribute.
     * `soft` Instructs the UA to add no line breaks to the submitted value of the textarea.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.wrap.hard
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.wrap.soft
     */
    public function wrap(string $value = 'hard'): self
    {
        if (!in_array($value, ['hard', 'soft'])) {
            throw new InvalidArgumentException('Invalid wrap value. Valid values are: hard, soft.');
        }

        $new = clone $this;
        $new->attributes['wrap'] = $value;
        return $new;
    }

    /**
     * A short hint (one word or a short phrase) intended to aid the user when entering data into the control
     * represented by its element.
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/textarea.html#textarea.attrs.placeholder
     */
    private function setPlaceholder(): void
    {
        if (!isset($this->attributes['placeholder'])) {
            $attributeName = $this->getAttributeName($this->attribute);
            $this->attributes['placeholder'] = $this->modelInterface->getAttributeLabel($attributeName);
        }
    }
}
