<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Html\Tag\Textarea as TextAreaTag;

final class TextArea extends Widget
{
    /**
     * Generates a textarea tag for the given form attribute.
     *
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
     * The minimum number of characters (as UTF-16 code units) the user can enter into the text input.
     *
     * This must be an non-negative integer value smaller than or equal to the value specified by maxlength.
     * If no minlength is specified, or an invalid value is specified, the text input has no minimum length.
     *
     * @param int $value
     *
     * @return self
     */
    public function minlength(int $value): self
    {
        $new = clone $this;
        $new->attributes['minlength'] = $value;
        return $new;
    }

    /**
     * The maxlength attribute defines the maximum number of characters (as UTF-16 code units) the user can enter into
     * an tag input.
     *
     * If no maxlength is specified, or an invalid value is specified, the tag input has no maximum length.
     *
     * @param int $value
     *
     * @return self
     */
    public function maxlength(int $value): self
    {
        $new = clone $this;
        $new->attributes['maxlength'] = $value;
        return $new;
    }

    /**
     * A Boolean attribute which, if present, means this field cannot be edited by the user.
     * Its value can, however, still be changed by JavaScript code directly setting the HTMLInputElement.value
     * property.
     *
     * @param bool $value
     *
     * @return self
     */
    public function readOnly(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['readonly'] = $value;
        return $new;
    }

    /**
     * Spellcheck is a global attribute which is used to indicate whether or not to enable spell checking for an
     * element.
     *
     * @param bool $value
     *
     * @return self
     */
    public function spellcheck(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['spellcheck'] = $value;
        return $new;
    }

    /**
     * The title global attribute contains text representing advisory information related to the element it belongs to.
     *
     * @param string $value
     *
     * @return self
     */
    public function title(string $value): self
    {
        $new = clone $this;
        $new->attributes['title'] = $value;
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
