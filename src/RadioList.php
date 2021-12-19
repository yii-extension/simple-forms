<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Closure;
use InvalidArgumentException;
use Stringable;
use Yii\Extension\Simple\Forms\Attribute\ChoiceAttributes;
use Yiisoft\Html\Widget\RadioList\RadioItem;
use Yiisoft\Html\Widget\RadioList\RadioList as RadioListTag;

/**
 * Generates a list of radio.
 */
final class RadioList extends ChoiceAttributes
{
    private array $containerAttributes = [];
    private ?string $containerTag = 'div';
    /** @psalm-var array[] */
    private array $individualItemsAttributes = [];
    /** @psalm-var array<array-key, string> */
    private array $items = [];
    private array $itemsAttributes = [];
    /** @psalm-var Closure(RadioItem):string|null */
    private ?Closure $itemsFormatter = null;
    /** @var bool[]|float[]|int[]|string[]|Stringable[] */
    private array $itemsFromValues = [];
    private string $separator = '';
    private ?string $uncheckValue = null;

    /**
     * The container attributes for generating the list of checkboxes tag using {@see CheckBoxList}.
     *
     * @param array $value
     *
     * @return static
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function containerAttributes(array $value): self
    {
        $new = clone $this;
        $new->containerAttributes = $value;
        return $new;
    }

    /**
     * The tag name for the container element.
     *
     * @param string|null $name tag name. if `null` disabled rendering.
     *
     * @return static
     */
    public function containerTag(?string $name = null): self
    {
        $new = clone $this;
        $new->containerTag = $name;
        return $new;
    }

    /**
     * The specified attributes for items.
     *
     * @param array $value
     *
     * @return static
     *
     * @psalm-param array[] $value
     */
    public function individualItemsAttributes(array $value = []): self
    {
        $new = clone $this;
        $new->individualItemsAttributes = $value;
        return $new;
    }

    /**
     * The data used to generate the list of radios.
     *
     * The array keys are the list of radio values, and the array values are the corresponding labels.
     *
     * Note that the labels will NOT be HTML-encoded, while the values will.
     *
     * @param array $value
     *
     * @return static
     *
     * @psalm-param array<array-key, string> $value
     */
    public function items(array $value = []): self
    {
        $new = clone $this;
        $new->items = $value;
        return $new;
    }

    /**
     * The attributes for generating the list of radio tag using {@see RadioList}.
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
     * Callable, a callback that can be used to customize the generation of the HTML code corresponding to a single
     * item in $items.
     *
     * The signature of this callback must be:
     *
     * ```php
     * function ($index, $label, $name, $checked, $value)
     * ```
     *
     * @param Closure|null $value
     *
     * @return static
     *
     * @psalm-param Closure(RadioItem):string|null $value
     */
    public function itemsFormatter(?Closure $value): self
    {
        $new = clone $this;
        $new->itemsFormatter = $value;
        return $new;
    }

    /**
     * The data used to generate the list of radios.
     *
     * The array keys are the list of radio values, and the array values are the corresponding labels.
     *
     * @param bool[]|float[]|int[]|string[]|Stringable[] $itemsFromValues
     *
     * @return static
     */
    public function itemsFromValues(array $itemsFromValues = []): self
    {
        $new = clone $this;
        $new->itemsFromValues = $itemsFromValues;
        return $new;
    }

    /**
     * The HTML code that separates items.
     *
     * @param string $value
     *
     * @return static
     */
    public function separator(string $value = ''): self
    {
        $new = clone $this;
        $new->separator = $value;
        return $new;
    }

    /**
     * @param bool|float|int|string|Stringable|null $value Value that corresponds to "unchecked" state of the input.
     *
     * @return static
     */
    public function uncheckValue($value): self
    {
        $new = clone $this;
        $new->uncheckValue = $value === null ? null : (string) $value;
        return $new;
    }

    /**
     * Generates a list of radio buttons.
     *
     * A radio button list is like a checkbox list, except that it only allows single selection.
     *
     * @return string the generated radio button list
     */
    protected function run(): string
    {
        $new = clone $this;

        /**
         * @var iterable<int, scalar|Stringable>|scalar|Stringable|null
         *
         * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-value
         */
        $value = $new->getAttributeValue();

        if (is_iterable($value) || is_object($value)) {
            throw new InvalidArgumentException('RadioList widget value can not be an iterable or an object.');
        }

        /** @var string */
        $name = $new->attributes['name'] ?? $new->getInputName();
        $new->containerAttributes['id'] ??= $new->getInputId();

        $radioList = RadioListTag::create($name);

        if ($new->items !== []) {
            $radioList = $radioList->items($new->items, $new->encode);
        } elseif ($new->itemsFromValues !== []) {
            $radioList = $radioList->itemsFromValues($new->itemsFromValues, $new->encode);
        }

        if ($new->separator !== '') {
            $radioList = $radioList->separator($new->separator);
        }

        return $radioList
            ->containerAttributes($new->containerAttributes)
            ->containerTag($new->containerTag)
            ->individualInputAttributes($new->individualItemsAttributes)
            ->itemFormatter($new->itemsFormatter)
            ->radioAttributes($new->attributes)
            ->replaceRadioAttributes($new->itemsAttributes)
            ->uncheckValue($new->uncheckValue)
            ->value(is_bool($value) ? (int) $value : $value)
            ->render();
    }
}
