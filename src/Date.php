<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yii\Extension\Simple\Forms\Attribute\CommonAttributes;
use Yii\Extension\Simple\Forms\Attribute\DateAttributes;
use Yii\Extension\Simple\Forms\Attribute\ModelAttributes;
use Yii\Extension\Simple\Model\Helper\HtmlModel;
use Yiisoft\Html\Tag\Input;
use Yii\Extension\Simple\Widget\AbstractWidget;

/*
 * The input element with a type attribute whose value is "date" represents a control for setting the element’s value to
 * a string representing a date.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date
 */
final class Date extends AbstractWidget
{
    use CommonAttributes;
    use DateAttributes;
    use ModelAttributes;

    /**
     * Generates a datepicker tag together with a label for the given form attribute.
     *
     * @return string the generated checkbox tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date.attrs.value */
        $value = HtmlModel::getAttributeValue($new->getModel(), $new->attribute);

        if (!is_string($value)) {
            throw new InvalidArgumentException('Date widget requires a string value.');
        }

        return Input::tag()
            ->type('date')
            ->attributes($new->attributes)
            ->id($new->getId())
            ->name(HtmlModel::getInputName($new->getModel(), $new->attribute))
            ->value($value)
            ->render();
    }
}
