<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Validator;

use Yii\Extension\Simple\Forms\AbstractWidget;
use Yii\Extension\Simple\Forms\Interface\HasLengthInterface;
use Yii\Extension\Simple\Forms\Interface\MatchRegularInterface;
use Yii\Extension\Simple\Forms\Interface\NumberInterface;
use Yii\Extension\Simple\Forms\Url;
use Yiisoft\Html\Html;
use Yiisoft\Validator\Rule;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\MatchRegularExpression;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Url as UrlValidator;

/**
 * Renders the field widget along with label and hint tag (if any) according to template.
 */
final class FieldValidator
{
    public function getValidatorAttributes(AbstractWidget $widget): AbstractWidget
    {
        /** @psalm-var array<array-key, Rule> */
        $rules = $widget->getFormModel()->getRules()[$widget->getAttribute()] ?? [];

        foreach ($rules as $rule) {
            if ($rule instanceof Required && $widget instanceof AbstractWidget) {
                $widget = $widget->required();
            }

            if ($rule instanceof HasLength && $widget instanceof HasLengthInterface) {
                $maxlength = (int)$rule->getOptions()['max'];
                $minlength = (int)$rule->getOptions()['min'];

                if ($maxlength > 0) {
                    $widget = $widget->maxlength($maxlength);
                }

                if ($minlength > 0) {
                    $widget = $widget->minlength($minlength);
                }
            }

            if ($rule instanceof MatchRegularExpression && $widget instanceof MatchRegularInterface) {
                /** @var string */
                $pattern = $rule->getOptions()['pattern'];
                $widget = $widget->pattern(Html::normalizeRegexpPattern($pattern));
            }

            if ($rule instanceof Number && $widget instanceof NumberInterface) {
                $max = (int)$rule->getOptions()['max'];
                $min = (int)$rule->getOptions()['min'];
                if ($max > 0) {
                    $widget = $widget->max($max);
                }

                if ($min > 0) {
                    $widget = $widget->min($min);
                }
            }

            if ($rule instanceof UrlValidator && $widget instanceof Url) {
                /** @var array<array-key, string> */
                $validSchemes = $rule->getOptions()['validSchemes'];

                $schemes = [];

                foreach ($validSchemes as $scheme) {
                    $schemes[] = $this->getSchemePattern($scheme);
                }

                /** @var array<array-key, float|int|string>|string */
                $pattern = $rule->getOptions()['pattern'];
                $normalizePattern = str_replace('{schemes}', '(' . implode('|', $schemes) . ')', $pattern);
                $widget = $widget->pattern(Html::normalizeRegexpPattern($normalizePattern));
            }
        }

        /** @var AbstractWidget */
        return $widget;
    }

    private function getSchemePattern(string $scheme): string
    {
        $result = '';

        for ($i = 0, $length = mb_strlen($scheme); $i < $length; $i++) {
            $result .= '[' . mb_strtolower($scheme[$i]) . mb_strtoupper($scheme[$i]) . ']';
        }

        return $result;
    }

}
