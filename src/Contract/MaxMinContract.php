<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Contract;

interface MaxMinContract
{
    /**
     * The expected upper bound for the element’s value.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.number.html#input.number.attrs.max
     */
    public function max(string $value): static;

    /**
     * The expected lower bound for the element’s value.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.number.html#input.number.attrs.min
     */
    public function min(string $value): static;
}
