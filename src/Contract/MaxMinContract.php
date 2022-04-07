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
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-max
     */
    public function max(string $value): static;

    /**
     * The expected lower bound for the element’s value.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-min
     */
    public function min(string $value): static;
}
