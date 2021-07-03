<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input as InputTag;

/**
 * Generates an text input tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.password.html#input.password
 */
final class PasswordInput extends Input
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

        return InputTag::password()->attributes($new->attributes)->name($name)->value($value)->render();
    }
}
