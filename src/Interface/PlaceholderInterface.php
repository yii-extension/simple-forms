<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Interface;

interface PlaceholderInterface
{
    /**
     * It allows defining placeholder.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#the-placeholder-attribute
     */
    public function placeholder(string $value): self;
}
