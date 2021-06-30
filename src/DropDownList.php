<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Tag\Optgroup;
use Yiisoft\Html\Tag\Option;
use Yiisoft\Html\Tag\Select;

final class DropDownList extends Widget
{
    private array $items = [];
    private array $itemsAttributes = [];
    private array $groups = [];
    private array $prompt = [];
    private ?string $unselectValue = null;

    /**
     * Generates a drop-down list for the given form attribute.
     *
     * The selection of the drop-down list is taken from the value of the form attribute.
     *
     * @return string the generated drop-down list tag.
     */
    public function run(): string
    {
        $new = clone $this;

        $id = $new->getId($new->modelInterface->getFormName(), $new->attribute);
        $name = $new->getInputName($new->modelInterface->getFormName(), $new->attribute);
        $promptOption = null;
        $value = $new->modelInterface->getAttributeValue($new->getAttributeName($new->attribute)) ?? '';

        if (isset($new->attributes['multiple']) && !isset($new->attributes['size'])) {
            $new = $new->size();
        }

        if ($new->prompt !== []) {
            /** @var string */
            $promptText = $new->prompt['text'] ?? '';

            /** @var array */
            $promptAttributes = $new->prompt['attributes'] ?? [];

            $promptOption = Option::tag()->attributes($promptAttributes)->content($promptText);
        }

        return Select::tag()
            ->attributes($new->attributes)
            ->id($id)
            ->items(...$new->renderItems($new->items))
            ->name($name)
            ->promptOption($promptOption)
            ->unselectValue($new->unselectValue)
            ->value($value)
            ->render();
    }

    /**
     * The attributes for the optgroup tags.
     *
     * The structure of this is similar to that of 'options', except that the array keys represent the optgroup labels
     * specified in $items.
     *
     * ```php
     * [
     *     'groups' => [
     *         '1' => ['label' => 'Chile'],
     *         '2' => ['label' => 'Russia']
     *     ],
     * ];
     * ```
     *
     * @param array $value
     *
     * @return static
     */
    public function groups(array $value = []): self
    {
        $new = clone $this;
        $new->groups = $value;
        return $new;
    }

    /**
     * The option data items.
     *
     * The array keys are option values, and the array values are the corresponding option labels. The array can also
     * be nested (i.e. some array values are arrays too). For each sub-array, an option group will be generated whose
     * label is the key associated with the sub-array. If you have a list of data {@see FormModel}, you may convert
     * them into the format described above using {@see \Yiisoft\Arrays\ArrayHelper::map()}
     *
     * Example:
     * ```php
     * [
     *     '1' => 'Santiago',
     *     '2' => 'Concepcion',
     *     '3' => 'Chillan',
     *     '4' => 'Moscu'
     *     '5' => 'San Petersburgo',
     *     '6' => 'Novosibirsk',
     *     '7' => 'Ekaterinburgo'
     * ];
     * ```
     *
     * Example with options groups:
     * ```php
     * [
     *     '1' => [
     *         '1' => 'Santiago',
     *         '2' => 'Concepcion',
     *         '3' => 'Chillan',
     *     ],
     *     '2' => [
     *         '4' => 'Moscu',
     *         '5' => 'San Petersburgo',
     *         '6' => 'Novosibirsk',
     *         '7' => 'Ekaterinburgo'
     *     ],
     * ];
     * ```
     *
     * @param array $value
     *
     * @return static
     */
    public function items(array $value = []): self
    {
        $new = clone $this;
        $new->items = $value;
        return $new;
    }

    /**
     * The HTML attributes for items. The following special options are recognized.
     *
     * @param array $value
     *
     * @return static
     */
    public function itemsAttributes(array $value = []): self
    {
        $new = clone $this;
        $new->itemsAttributes = $value;
        return $new;
    }

    /**
     * The Boolean multiple attribute, if set, means the widget accepts one or more values.
     *
     * Most browsers displaying a scrolling list box for a <select> control with the multiple attribute set versus a
     * single line dropdown when the attribute is false.
     *
     * @param bool $value
     *
     * @return static
     */
    public function multiple(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['multiple'] = $value;
        return $new;
    }

    /**
     * Prompt text to be displayed as the first option, you can use an array to override the value and to set other
     * tag attributes:
     *
     * ```php
     * [
     *     'prompt' => [
     *         'text' => 'Select City Birth',
     *         'options' => [
     *             'value' => '0',
     *             'selected' => 'selected'
     *         ],
     *     ],
     * ]
     * ```
     *
     * @param array $value
     *
     * @return static
     */
    public function prompt(array $value = []): self
    {
        $new = clone $this;
        $new->prompt = $value;
        return $new;
    }

    /**
     * The height of the <select> with multiple is true.
     *
     * Default value is 4.
     *
     * @param int $value
     *
     * @return static
     */
    public function size(int $value = 4): self
    {
        $new = clone $this;
        $new->attributes['size'] = $value;
        return $new;
    }

    /**
     * The value that should be submitted when none of the dropdown list is selected.
     *
     * You may set this option to be null to prevent default value submission. If this option is not set, an empty
     * string will be submitted.
     *
     * @param string $value
     *
     * @return static
     */
    public function unselectValue(string $value): self
    {
        $new = clone $this;
        $new->unselectValue = $value;
        return $new;
    }

    /**
     * @return Option[]|Optgroup[]
     */
    private function renderItems(array $values = []): array
    {
        $new = clone $this;
        $items = [];

        /** @var array|string $content */
        foreach ($values as $value => $content) {
            if (is_array($content)) {
                /** @var array */
                $groupAttrs = $new->groups[$value] ?? [];

                if (!isset($groupAttrs['label'])) {
                    $groupAttrs['label'] = $value;
                }

                $options = [];

                /** @var string $c */
                foreach ($content as $v => $c) {
                    /** @var array */
                    $attributes = $new->itemsAttributes[$v] ?? [];
                    $options[] = Option::tag()->attributes($attributes)->content($c)->value($v);
                }

                $items[] = Optgroup::tag()->attributes($groupAttrs)->options(...$options);
            } else {
                /** @var array */
                $attributes = $new->itemsAttributes[$value] ?? [];
                $items[] = Option::tag()->attributes($attributes)->content($content)->value($value);
            }
        }

        return $items;
    }
}
