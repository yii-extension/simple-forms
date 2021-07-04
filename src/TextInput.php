<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input as InputTag;

/**
 * Generates an text input tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text
 */
final class TextInput extends Input
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

        return InputTag::text()
            ->attributes($new->attributes)
            ->id($new->getId())
            ->name($new->getInputName())
            ->value($value)
            ->render();
    }

    /**
     * Enables submission of a value for the directionality of the element, and gives the name of the field that
     * contains that value.
     *
     * @param string $value Any string that is not empty.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.dirname
     */
    public function dirname(string $value): self
    {
        if (empty($value)) {
            throw new InvalidArgumentException('The value cannot be empty.');
        }

        $new = clone $this;
        $new->attributes['dirname'] = $value;
        return $new;
    }
}
