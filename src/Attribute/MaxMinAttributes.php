<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Attribute;

use Yii\Extension\Form\Contract\MaxMinContract;

abstract class MaxMinAttributes extends InputAttributes implements MaxMinContract
{
    /**
     * The latest acceptable date.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date.attrs.max
     */
    public function max(string $value): static
    {
        $new = clone $this;
        $new->attributes['max'] = $value;
        return $new;
    }

    /**
     * The earliest acceptable date.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date.attrs.min
     */
    public function min(string $value): static
    {
        $new = clone $this;
        $new->attributes['min'] = $value;
        return $new;
    }
}
