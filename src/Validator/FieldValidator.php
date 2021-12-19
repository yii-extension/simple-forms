<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Validator;

use Yii\Extension\Simple\Forms\Attribute\ChoiceAttributes;
use Yii\Extension\Simple\Forms\Attribute\InputAttributes;
use Yii\Extension\Simple\Forms\Interface\HasLengthInterface;
use Yii\Extension\Simple\Forms\Interface\MatchRegularInterface;
use Yii\Extension\Simple\Forms\Interface\NumberInterface;
use Yii\Extension\Simple\Forms\Url;
use Yii\Extension\Simple\Forms\Validator\FieldValidator;
use Yii\Extension\Simple\Model\FormModelInterface;
use Yiisoft\Html\Html;
use Yiisoft\Validator\Rule;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\MatchRegularExpression;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Url as UrlValidator;

/**
 * Renders the field widget along with label and hint tag (if any) according to template.
 *
 * @param ChoiceAttributes|InputAttributes $widget The field widget.
 * @param FormModelInterface $formModel The form model instance.
 * @param string $attribute The attribute name or expression.
 * @param array $attributes The HTML attributes for the field widget.
 *
 * @return array The attributes for validator html.
 */
final class FieldValidator
{
    public function getValidatorAttributes(
        ChoiceAttributes|InputAttributes $widget,
        FormModelInterface $formModel,
        string $attribute,
        array $attributes
    ): array {
        /** @psalm-var array<array-key, Rule> */
        $rules = $formModel->getRules()[$attribute] ?? [];

        foreach ($rules as $rule) {
            if ($rule instanceof Required) {
                $attributes['required'] = true;
            }

            if ($rule instanceof HasLength && $widget instanceof HasLengthInterface) {
                /** @var int|null */
                $attributes['maxlength'] = $rule->getOptions()['max'] !== 0 ? $rule->getOptions()['max'] : null;
                /** @var int|null */
                $attributes['minlength'] = $rule->getOptions()['min'] !== 0 ? $rule->getOptions()['min'] : null;
            }

            if ($rule instanceof MatchRegularExpression && $widget instanceof MatchRegularInterface) {
                /** @var string */
                $pattern = $rule->getOptions()['pattern'];
                $attributes['pattern'] = Html::normalizeRegexpPattern($pattern);
            }

            if ($rule instanceof Number && $widget instanceof NumberInterface) {
                /** @var int|null */
                $attributes['max'] = $rule->getOptions()['max'] !== 0 ? $rule->getOptions()['max'] : null;
                /** @var int|null */
                $attributes['min'] = $rule->getOptions()['min'] !== 0 ? $rule->getOptions()['min'] : null;
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
                $attributes['pattern'] = Html::normalizeRegexpPattern($normalizePattern);
            }
        }

        return $attributes;
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
