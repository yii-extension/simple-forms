<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yiisoft\Html\Tag\CustomTag;

/**
 * The Error widget displays an error message.
 */
final class Error extends AbstractForm
{
    private string $message = '';
    private string $tag = 'div';

    /**
     * Error message to display.
     *
     * @return static
     */
    public function message(string $value): self
    {
        $new = clone $this;
        $new->message = $value;
        return $new;
    }

    /**
     * The tag name of the container element.
     *
     * Empty to render error messages without container {@see Html::tag()}.
     *
     * @param string $value
     *
     * @return static
     */
    public function tag(string $value): self
    {
        $new = clone $this;
        $new->tag = $value;
        return $new;
    }

    /**
     * Generates a tag that contains the first validation error of the specified form attribute.
     *
     * @return string the generated label tag
     */
    protected function run(): string
    {
        $new = clone $this;

        return $new->tag !== '' && $new->message !== ''
            ? CustomTag::name($new->tag)
                ->attributes($new->attributes)
                ->content($new->message)
                ->encode($new->encode)
                ->render()
            : $new->message;
    }
}
