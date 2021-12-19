<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Closure;
use InvalidArgumentException;
use Stringable;
use Yii\Extension\Simple\Forms\Attribute\ChoiceAttributes;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;
use Yiisoft\Html\Widget\CheckboxList\CheckboxList as CheckboxListTag;

/*
 * Generates a list of checkboxes.
 *
 * A checkbox list allows multiple selection.
 */
final class CheckboxList extends ChoiceAttributes
{
    private array $containerAttributes = [];
    private ?string $containerTag = 'div';
    /** @psalm-var array[] $value */
    private array $individualItemsAttributes = [];
    /** @var string[] */
    private array $items = [];
    /** @var bool[]|float[]|int[]|string[]|Stringable[] */
    private array $itemsAsValues = [];
    private array $itemsAttributes = [];
    /** @psalm-var Closure(CheckboxItem):string|null */
    private ?Closure $itemsFormatter = null;
    /** @var bool[]|float[]|int[]|string[]|Stringable[] */
    private array $itemsFromValues = [];
    private string $separator = "\n";

    /**
     * The container attributes for generating the list of checkboxes tag using {@see CheckBoxList}.
     *
     * @param array $attributes
     *
     * @return static
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function containerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->containerAttributes = $attributes;
        return $new;
    }

    /**
     * The tag name for the container element.
     *
     * @param string|null $tag tag name. if `null` disabled rendering.
     *
     * @return static
     */
    public function containerTag(?string $tag = null): self
    {
        $new = clone $this;
        $new->containerTag = $tag;
        return $new;
    }

    /**
     * Set the ID of container the widget.
     *
     * @param string|null $id
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-id-attribute
     */
    public function id(?string $id): self
    {
        $new = clone $this;
        $new->containerAttributes['id'] = $id;
        return $new;
    }

    /**
     * The specified attributes for items.
     *
     * @param array $attributes
     *
     * @return static
     *
     * @psalm-param array[] $attributes
     */
    public function individualItemsAttributes(array $attributes = []): self
    {
        $new = clone $this;
        $new->individualItemsAttributes = $attributes;
        return $new;
    }

    /**
     * The data used to generate the list of checkboxes.
     *
     * The array keys are the list of checkboxes values, and the array key values are the corresponding labels.
     *
     * @param string[] $items
     *
     * @return static
     */
    public function items(array $items = []): self
    {
        $new = clone $this;
        $new->items = $items;
        return $new;
    }

    /**
     * The items attribute for generating the list of checkboxes tag using {@see CheckBoxList}.
     *
     * @param array $attributes
     *
     * @return static
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function itemsAttributes(array $attributes = []): self
    {
        $new = clone $this;
        $new->itemsAttributes = $attributes;
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
     * @param Closure|null $formatter
     *
     * @return static
     *
     * @psalm-param Closure(CheckboxItem):string|null $formatter
     */
    public function itemsFormatter(?Closure $formatter): self
    {
        $new = clone $this;
        $new->itemsFormatter = $formatter;
        return $new;
    }

    /**
     * The data used to generate the list of checkboxes.
     *
     * The array keys are the list of checkboxes values, and the array values are the corresponding labels.
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
     * @param string $separator
     *
     * @return static
     */
    public function separator(string $separator): self
    {
        $new = clone $this;
        $new->separator = $separator;
        return $new;
    }

    /**
     * The tabindex global attribute indicates that its element can be focused, and where it participates in sequential
     * keyboard navigation (usually with the Tab key, hence the name).
     *
     * It accepts an integer as a value, with different results depending on the integer's value:
     *
     * - A negative value (usually tabindex="-1") means that the element is not reachable via sequential keyboard
     * navigation, but could be focused with Javascript or visually. It's mostly useful to create accessible widgets
     * with JavaScript.
     * - tabindex="0" means that the element should be focusable in sequential keyboard navigation, but its order is
     * defined by the document's source order.
     * - A positive value means the element should be focusable in sequential keyboard navigation, with its order
     * defined by the value of the number. That is, tabindex="4" is focused before tabindex="5", but after tabindex="3".
     *
     * @param int $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/interaction.html#attr-tabindex
     */
    public function tabIndex(int $value): self
    {
        $new = clone $this;
        $new->containerAttributes['tabindex'] = $value;
        return $new;
    }

    /**
     * @return string the generated checkbox list.
     */
    protected function run(): string
    {
        $new = clone $this;

        /**
         *  @var iterable<int, scalar|Stringable>|scalar|Stringable|null
         *
         *  @link https://html.spec.whatwg.org/multipage/input.html#attr-input-value
         */
        $value = $new->attributes['value'] ?? $new->getAttributeValue();
        unset($new->attributes['value']);

        if (!is_iterable($value) && null !== $value) {
            throw new InvalidArgumentException('CheckboxList widget must be a array or null value.');
        }

        $name = $new->getInputName();

        /** @var string */
        if (!empty($new->attributes['name']) && is_string($new->attributes['name'])) {
            $name = $new->attributes['name'];
        }

        $checkboxList = CheckboxListTag::create($name);

        if (!array_key_exists('id', $new->containerAttributes)) {
            $new->containerAttributes['id'] = $new->getInputId();
        }

        if ($new->items !== []) {
            $checkboxList = $checkboxList->items($new->items, $new->encode);
        } elseif ($new->itemsFromValues !== []) {
            $checkboxList = $checkboxList->itemsFromValues($new->itemsFromValues, $new->encode);
        }

        if ($new->itemsAttributes !== []) {
            $checkboxList = $checkboxList->replaceCheckboxAttributes($new->itemsAttributes);
        }

        return $checkboxList
            ->checkboxAttributes($new->attributes)
            ->containerAttributes($new->containerAttributes)
            ->containerTag($new->containerTag)
            ->individualInputAttributes($new->individualItemsAttributes)
            ->itemFormatter($new->itemsFormatter)
            ->separator($new->separator)
            ->values($value ?? [])
            ->render();
    }
}
