<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Html\Tag\CustomTag;

/**
 * Generates a hint tag for the given form attribute.
 */
final class Hint extends Widget
{
    private string $hint = '';
    private string $tag = 'div';

    /**
     * @return string the generated hint tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        $hint = $new->modelInterface->getAttributeHint($new->attribute) !== ''
            ? $new->modelInterface->getAttributeHint($new->attribute) : $new->hint;

        if (empty($new->tag)) {
            throw new InvalidArgumentException('The tag cannot be empty.');
        }

        return
            $hint !== ''
                ? CustomTag::name($new->tag)
                    ->attributes($new->attributes)
                    ->content($hint)
                    ->id($new->getId() . '-hint')
                    ->render()
                : '';
    }

    /**
     * This specifies the hint to be displayed.
     *
     * Note that this will NOT be encoded.
     * If this is not set, {@see \Yii\Extension\Simple\Model\ModelInterface::getAttributeHint()} will be called to get
     * the hint for display (without encoding).
     *
     * @param string $value
     *
     * @return static
     */
    public function hint(string $value): self
    {
        $new = clone $this;
        $new->hint = $value;
        return $new;
    }

    /**
     * The tag name of the container element.
     *
     * Null to render hint without container {@see Html::tag()}.
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
}
