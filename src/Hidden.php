<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yii\Extension\Simple\Forms\Attribute\ModelAttributes;
use Yii\Extension\Simple\Model\Helper\HtmlModel;
use Yiisoft\Html\Tag\Input;
use Yii\Extension\Simple\Widget\AbstractWidget;

/**
 * The input element with a type attribute whose value is "hidden" represents a value that is not intended to be
 * examined or manipulated by the user.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.hidden.html#input.hidden
 */
final class Hidden extends AbstractWidget
{
    use ModelAttributes;

    /**
     * Generates a hidden input tag for the given form attribute.
     *
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.hidden.html#input.hidden.attrs.value */
        $value = HtmlModel::getAttributeValue($new->getModel(), $new->attribute);

        if (!is_string($value)) {
            throw new InvalidArgumentException('Hidden widget requires a string value.');
        }

        return Input::hidden($new->getId(), $value)->attributes($new->attributes)->render();
    }
}
