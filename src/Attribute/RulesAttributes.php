<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Attribute;

use Yii\Extension\Form\Contract\HasLengthContract;
use Yii\Extension\Form\Contract\RegexContract;

abstract class RulesAttributes extends InputAttributes implements HasLengthContract, RegexContract
{
    public function maxlength(int $value): self
    {
        $new = clone $this;
        $new->attributes['maxlength'] = $value;
        return $new;
    }

    public function minlength(int $value): self
    {
        $new = clone $this;
        $new->attributes['minlength'] = $value;
        return $new;
    }

    public function pattern(string $value): self
    {
        $new = clone $this;
        $new->attributes['pattern'] = $value;
        return $new;
    }
}
