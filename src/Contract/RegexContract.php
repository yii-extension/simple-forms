<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Contract;

interface RegexContract
{
    /**
     * The pattern attribute, when specified, is a regular expression that the input's value must match in order for
     * the value to pass constraint validation. It must be a valid JavaScript regular expression, as used by the
     * RegExp type.
     *
     * @param string $value
     *
     * @return self
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#the-pattern-attribute
     */
    public function pattern(string $value): self;
}
