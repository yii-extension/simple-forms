<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input as InputTag;

/**
 * Generates an text input tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text
 */
final class TextInput extends Input
{
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

        return InputTag::text()->attributes($new->attributes)->name($name)->value($value)->render();
    }

    /**
     * Enables submission of a value for the directionality of the element, and gives the name of the field that
     * contains that value.
     *
     * @param string $value Any string that is not empty.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.dirname
     */
    public function dirname(string $value): self
    {
        if (empty($value)) {
            throw new InvalidArgumentException('The value cannot be empty.');
        }

        $new = clone $this;
        $new->attributes['dirname'] = $value;
        return $new;
    }
}
