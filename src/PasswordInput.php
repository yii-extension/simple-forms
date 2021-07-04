<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input as InputTag;

/**
 * Generates an text input tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.password.html#input.password
 */
final class PasswordInput extends Input
{
    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        $new->validateConfig();

        $value = $new->getValue();

        if ($new->getNoPlaceholder() === false) {
            $new->setPlaceholder();
        }

        $new = $new->addValidateCssClass($new);

        if (!is_scalar($value)) {
            throw new InvalidArgumentException('The value must be a bool|float|int|string|Stringable|null.');
        }

        return InputTag::password()
            ->attributes($new->attributes)
            ->id($new->getId())
            ->name($new->getInputName())
            ->value($value)
            ->render();
    }
}
