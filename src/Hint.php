<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yiisoft\Html\Html;

final class Hint extends Widget
{
    private string $hint = '';

    /**
     * Generates a hint tag for the given form attribute.
     *
     * @return string the generated hint tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        $hint = $new->modelInterface->getAttributeHint($new->attribute) !== ''
            ? $new->modelInterface->getAttributeHint($new->attribute) : $new->hint;

        $new->attributes['id'] = $new->getId($new->modelInterface->getFormName(), $new->attribute) . '-hint';

        return $hint !== '' ? Html::tag('div', $hint, $new->attributes)->render() : '';
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
     * @return self
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
     * @param string|null $value
     *
     * @return self
     */
    public function tag(string $value = null): self
    {
        $new = clone $this;
        $new->attributes['tag'] = $value;
        return $new;
    }
}
