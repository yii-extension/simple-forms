<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yii\Extension\Simple\Forms\Attribute\CommonAttributes;
use Yii\Extension\Simple\Forms\Attribute\ModelAttributes;
use Yii\Extension\Simple\Model\Helper\HtmlModel;
use Yiisoft\Html\Tag\Input;
use Yii\Extension\Simple\Widget\AbstractWidget;

/**
 * The input element with a type attribute whose value is "range" represents an imprecise control for setting the
 * element’s value to a string representing a number.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.number.html
 */
final class Range extends AbstractWidget
{
    use CommonAttributes;
    use ModelAttributes;

    /**
     * The expected upper bound for the element’s value.
     *
     * @param int $max
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.range.html#input.range.attrs.max
     */
    public function max(int $value): self
    {
        $new = clone $this;
        $new->attributes['max'] = $value;
        return $new;
    }

    /**
     * The expected lower bound for the element’s value.
     *
     * @param int $min
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.range.html#input.range.attrs.min
     */
    public function min(int $value): self
    {
        $new = clone $this;
        $new->attributes['min'] = $value;
        return $new;
    }

    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.range.html#input.range.attrs.value */
        $value = HtmlModel::getAttributeValue($new->getModel(), $new->attribute);

        if (!is_numeric($value)) {
            throw new InvalidArgumentException('Range widget must be a numeric value.');
        }

        return Input::tag()
            ->type('range')
            ->attributes($new->attributes)
            ->id($new->getId())
            ->name(HtmlModel::getInputName($new->getModel(), $new->attribute))
            ->value($value)
            ->render();
    }
}
