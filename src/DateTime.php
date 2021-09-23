<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yii\Extension\Simple\Forms\Attribute\CommonAttributes;
use Yii\Extension\Simple\Forms\Attribute\DateAttributes;
use Yii\Extension\Simple\Forms\Attribute\ModelAttributes;
use Yii\Extension\Simple\Model\Helper\HtmlModel;
use Yii\Extension\Simple\Widget\AbstractWidget;
use Yiisoft\Html\Tag\Input;

/**
 * The input element with a type attribute whose value is "datetime" represents a control for setting the element’s
 * value to a string representing a global date and time (with timezone information).
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.datetime.html#input.datetime
 */
final class DateTime extends AbstractWidget
{
    use CommonAttributes;
    use DateAttributes;
    use ModelAttributes;

    /**
     * Generates a datetime input element for the given model attribute.
     *
     * @return string
     */
    protected function run(): string
    {
        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date.attrs.value */
        $value = HtmlModel::getAttributeValue($this->getModel(), $this->attribute);

        if (!is_string($value)) {
            throw new InvalidArgumentException('DateTime widget requires a string value.');
        }

        return Input::tag()
            ->type('datetime')
            ->attributes($this->attributes)
            ->id($this->getId())
            ->name(HtmlModel::getInputName($this->getModel(), $this->attribute))
            ->value($value)
            ->render();
    }
}
