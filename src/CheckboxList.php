<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Closure;
use Stringable;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;
use Yiisoft\Html\Widget\CheckboxList\CheckboxList as ChecboxListWidget;

/*
 * Generates a list of checkboxes.
 *
 * A checkbox list allows multiple selection, like {@see ListBox}.
 */
final class CheckboxList extends Widget
{
    private array $containerAttributes = [];
    private ?string $containerTag = 'div';
    /** @psalm-var Closure(CheckboxItem):string|null */
    private ?Closure $itemFormatter = null;
    /** @var array<array-key, string> */
    private array $items = [];
    private array $itemsAttributes = [];

    /**
     * The container attributes for generating the list of checkboxes tag using {@see CheckBoxList}.
     *
     * @param array $value
     *
     * @return static
     */
    public function containerAttributes(array $value): self
    {
        $new = clone $this;
        $new->containerAttributes = $value;
        return $new;
    }

    public function containerTag(?string $name): self
    {
        $new = clone $this;
        $new->containerTag = $name;
        return $new;
    }

    /**
     * Callable, a callback that can be used to customize the generation of the HTML code corresponding to a single
     * item in $items.
     *
     * The signature of this callback must be:
     *
     * ```php
     * function ($index, $label, $name, $checked, $value)
     * ```
     *
     * @param Closure(CheckboxItem):string|null $formatter
     *
     * @return static
     */
    public function itemFormater(?Closure $formatter): self
    {
        $new = clone $this;
        $new->itemFormatter = $formatter;
        return $new;
    }

    /**
     * The data used to generate the list of checkboxes.
     *
     * The array keys are the list of checkboxes values, and the array values are the corresponding labels.
     *
     * Note that the labels will NOT be HTML-encoded, while the values will.
     *
     * @param array<array-key, string> $value
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
     * The items atrributes for generating the list of checkboxes tag using {@see CheckBoxList}.
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
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-readonly-attribute
     *
     * @return static
     */
    public function readonly(): self
    {
        $new = clone $this;
        $new->itemsAttributes['readonly'] = true;
        return $new;
    }

    /**
     * The HTML code that separates items.
     *
     * @param string $value
     *
     * @return static
     */
    public function separator(string $value): self
    {
        $new = clone $this;
        $new->attributes['separator'] = $value;
        return $new;
    }

    /**
     * Disabled container tag.
     *
     * @return static
     */
    public function withoutContainer(): self
    {
        $new = clone $this;
        $new->containerTag = null;
        return $new;
    }

    /**
     * @return string the generated checkbox list.
     */
    protected function run(): string
    {
        $new = clone $this;

        $checkboxList = ChecboxListWidget::create($new->getInputName());

        $new->containerAttributes['id'] = $new->containerAttributes['id'] ?? $new->getId();

        /** @var null|scalar|Stringable|iterable<int, Stringable|scalar> */
        $values = $new->getValue();

        /** @var string */
        $separator = $new->attributes['separator'] ?? '';

        unset($new->attributes['itemsAttributes'], $new->attributes['separator']);

        if ($separator !== '') {
            $checkboxList = $checkboxList->separator($separator);
        }

        if (is_iterable($values)) {
            $checkboxList = $checkboxList->values($values);
        } elseif (is_scalar($values)) {
            $checkboxList = $checkboxList->value($values);
        }

        return $checkboxList
            ->checkboxAttributes($new->attributes)
            ->containerAttributes($new->containerAttributes)
            ->containerTag($new->containerTag)
            ->itemFormatter($new->itemFormatter)
            ->items($new->items)
            ->replaceCheckboxAttributes($new->itemsAttributes)
            ->uncheckValue(null)
            ->render();
    }
}
