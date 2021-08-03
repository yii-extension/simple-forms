<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use ReflectionException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;
use Yii\Extension\Simple\Forms\Attribute\FormAttribute;

use function strtr;

/**
 * Renders the field widget along with label and hint tag (if any) according to template.
 */
final class Field extends FormAttribute
{
    private bool $ariaDescribedBy = false;
    private string $containerClass = '';
    private string $errorClass = '';
    private string $errorMessage = '';
    private string $hintClass = '';
    private string $inputClass = '';
    private string $labelClass = '';
    private string $invalidClass = '';
    private string $validClass = '';
    private bool $noHint = false;
    private bool $noLabel = false;
    private array $parts = [];
    private string $template = '';

    /**
     * Set aria-describedby attribute.
     *
     * @return static
     */
    public function ariaDescribedBy(): self
    {
        $new = clone $this;
        $new->ariaDescribedBy = true;
        return $new;
    }

    /**
     * Set container css class.
     *
     * @return static
     */
    public function containerClass(string $value): self
    {
        $new = clone $this;
        $new->containerClass = $value;
        return $new;
    }

    /**
     * Renders a drop-down list.
     *
     * The selection of the drop-down list is taken from the value of the model attribute.
     *
     * @param array $items the option data items. The array keys are option values, and the array values are the
     * corresponding option labels. The array can also be nested (i.e. some array values are arrays too).
     * For each sub-array, an option group will be generated whose label is the key associated with the sub-array.
     * If you have a list of data models, you may convert them into the format described above using
     * {@see \Yiisoft\Arrays\ArrayHelper::map()}.
     *
     * @param array $attributes the tag attributes in terms of name-value pairs.
     *
     * For the list of available attributes please refer to the `$attributes` parameter
     * {@see \Yiisoft\Html\Tag\Select()}.
     *
     * If you set a custom `id` for the input element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @param array $groups The attributes for the optgroup tags.
     *
     * The structure of this is similar to that of 'options', except that the array keys represent the optgroup labels
     * specified in {@see DropdownList::items()};
     *
     * ```php
     * [
     *     'groups' => [
     *         '1' => ['label' => 'Chile'],
     *         '2' => ['label' => 'Russia']
     *     ],
     * ];
     *
     * @param array $prompt Text to be displayed as the first option, you can use an array to override the value and to
     * set other tag attributes:
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
     * @param string|null $unselectValue
     *
     * @throws ReflectionException
     *
     * @return static the field object itself.
     */
    public function dropDownList(
        array $items,
        array $attributes = [],
        array $groups = [],
        array $prompt = [],
        string $unselectValue = null
    ): self {
        $new = clone $this;

        if ($new->inputClass !== '') {
            Html::addCssClass($attributes, $new->inputClass);
        }

        $new->parts['{input}'] = DropDownList::widget()
            ->attributes($attributes)
            ->config($new->getModelInterface(), $new->getAttribute())
            ->items($items)
            ->groups($groups)
            ->prompt($prompt)
            ->unselectValue($unselectValue);

        return $new;
    }

    /**
     * Generates a tag that contains the first validation error of {@see attribute}.
     *
     * Note that even if there is no validation error, this method will still return an empty error tag.
     *
     * @param array $attributes the tag attributes in terms of name-value pairs.
     * The attributes will be rendered as the attributes of the resulting tag. The values will be HTML-encoded using
     * {@see Html::encode()}. If this parameter is `false`, no error tag will be rendered.
     *
     * The following attributes are specially handled:
     *
     * If you set a custom `id` for the error element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @throws ReflectionException
     *
     * @return static the field object itself.
     */
    public function error(array $attributes = []): self
    {
        $new = clone $this;

        if ($new->errorClass !== '') {
            Html::addCssClass($attributes, $new->errorClass);
        }

        $new->parts['{error}'] = Error::widget()
            ->attributes($attributes)
            ->config($new->getModelInterface(), $new->getAttribute())
            ->message($new->errorMessage) . "\n";

        return $new;
    }

    /**
     * Set error css class.
     *
     * @return static
     */
    public function errorClass(string $value): self
    {
        $new = clone $this;
        $new->errorClass = $value;
        return $new;
    }

    /**
     * Set error description message.
     *
     * @return static
     */
    public function errorMessage(string $value): self
    {
        $new = clone $this;
        $new->errorMessage = $value;
        return $new;
    }

    /**
     * Renders the hint tag.
     *
     * @param string $content the hint content.
     * If ``, the hint will be generated via {@see \Yii\Extension\Simple\Model\ModelInterface::getAttributeHint()}.
     * @param array $attributes the tag attributes in terms of name-value pairs. These will be rendered as the
     * attributes of the hint tag. The values will be HTML-encoded using {@see Html::encode()}.
     *
     * @throws ReflectionException
     *
     * @return static
     */
    public function hint(string $content = '', array $attributes = []): self
    {
        $new = clone $this;
        $new->parts['{hint}'] = '';

        if ($new->noHint === false) {
            if ($new->hintClass !== '') {
                Html::addCssClass($attributes, $new->hintClass);
            }

            /** @var string */
            $tag = $new->attributes['tag'] ?? 'div';

            unset($new->attributes['tag']);

            $new->parts['{hint}'] = Hint::widget()
                ->attributes($attributes)
                ->config($new->getModelInterface(), $new->getAttribute())
                ->hint($content)
                ->tag($tag) . PHP_EOL;
        }

        return $new;
    }

    /**
     * Set hint css class.
     *
     * @return static
     */
    public function hintClass(string $value): self
    {
        $new = clone $this;
        $new->hintClass = $value;
        return $new;
    }

    /**
     * Renders a text input.
     *
     * This method will generate the `name` and `value` tag attributes automatically for the model attribute unless they
     * are explicitly specified in `$attributes`.
     *
     * @param array $attributes the tag attributes in terms of name-value pairs. These will be rendered as the
     * attributes of the resulting tag. The values will be HTML-encoded using {@see Html::encode()}.
     *
     * The following special attributes are recognized:
     *
     * Note that if you set a custom `id` for the input element, you may need to adjust the value of {@see selectors}
     * accordingly.
     *
     * @throws ReflectionException
     *
     * @return static
     */
    public function input(array $attributes = []): self
    {
        $new = clone $this;

        Html::addCssClass($attributes, $new->inputClass);

        if ($new->ariaDescribedBy === true) {
            $attributes['aria-describedby'] = $new->getId() . '-hint';
        }

        $new->parts['{input}'] = TextInput::widget()
            ->attributes($attributes)
            ->config($new->getModelInterface(), $new->getAttribute())
            ->invalidClass($new->invalidClass)
            ->validClass($new->validClass) . PHP_EOL;

        return $new;
    }

    /**
     * Set input css class.
     *
     * @return static
     */
    public function inputClass(string $value): self
    {
        $new = clone $this;
        $new->inputClass = $value;
        return $new;
    }

    /**
     * Set invalid css class.
     *
     * @return static
     */
    public function invalidClass(string $value): self
    {
        $new = clone $this;
        $new->invalidClass = $value;
        return $new;
    }

    /**
     * Generates a label tag for {@see attribute}.
     *
     * @param string $label the label to use.
     * @param array $attributes the tag attributes in terms of name-value pairs.
     * The attributes will be rendered as the attributes of the resulting tag. The values will be HTML-encoded using
     * {@see Html::encode()}. If a value is `null`, the corresponding attribute will not be rendered.
     * If `null`, the label will be generated via
     * {@see \Yii\Extension\Simple\Model\ModelInterface::getAttributeLabel()}.
     *
     * Note that this will NOT be {@see Html::encode()|encoded}.
     *
     * @throws ReflectionException
     *
     * @return static
     */
    public function label(string $label = '', array $attributes = []): self
    {
        $new = clone $this;
        $new->parts['{label}'] = '';

        if ($new->noLabel === false) {
            if ($new->labelClass !== '') {
                Html::addCssClass($attributes, $new->labelClass);
            }

            $new->parts['{label}'] = Label::widget()
                ->attributes($attributes)
                ->config($new->getModelInterface(), $new->getAttribute())
                ->label($label) . PHP_EOL;
        }

        return $new;
    }

    /**
     * Set the label css class.
     *
     * @return static
     */
    public function labelClass(string $value): self
    {
        $new = clone $this;
        $new->labelClass = $value;
        return $new;
    }


    /**
     * Set disabled hint.
     *
     * @return static
     */
    public function noHint(): self
    {
        $new = clone $this;
        $new->noHint = true;
        return $new;
    }

    /**
     * Set disabled label.
     * @return static
     */
    public function noLabel(): self
    {
        $new = clone $this;
        $new->noLabel = true;
        return $new;
    }

    /**
     * Renders a password input.
     *
     * This method will generate the `name` and `value` tag attributes automatically for the model attribute unless
     * they are explicitly specified in `$attributes`.
     *
     * @param array $attributes the tag attributes in terms of name-value pairs. These will be rendered as the
     * attributes of the resulting tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     *
     * If you set a custom `id` for the input element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @throws ReflectionException
     *
     * @return static
     */
    public function passwordInput(array $attributes = []): self
    {
        $new = clone $this;

        Html::addCssClass($attributes, $new->inputClass);

        if ($new->ariaDescribedBy === true) {
            $attributes['aria-describedby'] = $new->getId() . '-hint';
        }

        $new->parts['{input}'] = PasswordInput::widget()
            ->attributes($attributes)
            ->config($new->getModelInterface(), $new->getAttribute())
            ->invalidClass($new->invalidClass)
            ->validClass($new->validClass) . PHP_EOL;

        return $new;
    }

    /**
     * Set layout template for render a field.
     *
     * @param string $template
     *
     * @return static
     */
    public function template(string $value): self
    {
        $new = clone $this;
        $new->template = $value;
        return $new;
    }

    /**
     * Renders a text area.
     *
     * The model attribute value will be used as the content in the textarea.
     *
     * @param array $attributes the tag attributes in terms of name-value pairs. These will be rendered as the
     * attributes of the resulting tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     *
     * If you set a custom `id` for the textarea element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @throws ReflectionException
     *
     * @return static the field object itself.
     */
    public function textArea(array $attributes = []): self
    {
        $new = clone $this;

        $new->parts['{input}'] = TextArea::widget()
            ->attributes($attributes)
            ->config($new->getModelInterface(), $new->getAttribute())
            ->render();

        return $new;
    }

    /**
     * Set the value valid css class.
     *
     * @param string $value is the valid css class.
     *
     * @return static
     */
    public function validClass(string $value): self
    {
        $new = clone $this;
        $new->validClass = $value;
        return $new;
    }

    /**
     * Renders the whole field.
     *
     * This method will generate the label, input tag and hint tag (if any), and assemble them into HTML according to
     * {@see template}.
     *
     * If (not set), the default methods will be called to generate the label and input tag, and use them as the
     * content.
     *
     * @throws ReflectionException
     *
     * @return string the rendering result.
     */
    protected function run(): string
    {
        $new = clone $this;

        $div = Div::tag();

        if (!isset($new->parts['{label}'])) {
            $new = $new->label();
        }

        if (!isset($new->parts['{input}'])) {
            $new = $new->input();
        }

        if (!isset($new->parts['{hint}'])) {
            $new = $new->hint();
        }

        if (!isset($this->parts['{error}'])) {
            $new = $new->error();
        }

        if ($new->containerClass !== '') {
            $div = $div->class($new->containerClass);
        }

        return $div->content("\n" . strtr($new->template, $new->parts))->encode(false)->render();
    }
}
