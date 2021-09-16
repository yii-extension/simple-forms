<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yii\Extension\Simple\Forms\Attribute\ModelAttributes;
use Yii\Extension\Simple\Model\Helper\HtmlModel;
use Yii\Extension\Simple\Widget\AbstractWidget;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Tag\CustomTag;

/**
 * The widget for hint form.
 */
final class Hint extends AbstractWidget
{
    use ModelAttributes;

    /**
     * Generates a hint tag for the given model attribute.
     *
     * @return string
     */
    protected function run(): string
    {
        $new = clone $this;

        /** @var bool */
        $encode = $new->attributes['encode'] ?? false;

        /** @var bool|string */
        $hint = ArrayHelper::remove(
            $new->attributes,
            'hint',
            HtmlModel::getAttributeHint($new->getModel(), $new->attribute),
        );

        /** @psalm-var non-empty-string */
        $tag = $new->attributes['tag'] ?? 'div';

        unset($new->attributes['hint'], $new->attributes['tag']);

        return (!is_bool($hint) && $hint !== '')
            ? CustomTag::name($tag)->attributes($new->attributes)->content($hint)->encode($encode)->render()
            : '';
    }
}
