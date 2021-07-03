<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use ReflectionException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;

use function strtr;

/**
 * Renders the field widget along with label and hint tag (if any) according to template.
 */
final class Field extends Widget
{
    private bool $ariaDescribedBy = false;
    private string $containerCssClass = '';
    private string $errorCssClass = '';
    private string $errorMessage = '';
    private string $hintCssClass = '';
    private string $inputCssClass = '';
    private string $labelCssClass = '';
    private string $invalidCssClass = '';
    private string $validCssClass = '';
    private bool $noHint = false;
    private bool $noLabel = false;
    private array $parts = [];
    private string $template = '';

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

        return Div::tag()
            ->class($new->containerCssClass)
            ->content("\n" . strtr($new->template, $new->parts))
            ->encode(false)
            ->render();
    }

    public function ariaDescribedBy(): self
    {
        $new = clone $this;
        $new->ariaDescribedBy = true;
        return $new;
    }

    public function containerCssClass(string $value): self
    {
        $new = clone $this;
        $new->containerCssClass = $value;
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

        Html::addCssClass($attributes, $new->inputCssClass);

        $new->parts['{input}'] = DropDownList::widget()
            ->config($new->modelInterface, $new->attribute, $attributes)
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

        Html::addCssClass($attributes, $new->errorCssClass);

        $new->parts['{error}'] = Error::widget()
            ->config($new->modelInterface, $new->attribute, $attributes)
            ->message($new->errorMessage) . "\n";

        return $new;
    }

    public function errorCssClass(string $value): self
    {
        $new = clone $this;
        $new->errorCssClass = $value;
        return $new;
    }

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
            Html::addCssClass($attributes, $new->hintCssClass);

            /** @var string */
            $tag = $new->attributes['tag'] ?? 'div';

            unset($new->attributes['tag']);

            $new->parts['{hint}'] = Hint::widget()
                ->config($new->modelInterface, $new->attribute, $attributes)
                ->hint($content)
                ->tag($tag) . PHP_EOL;
        }

        return $new;
    }

    public function hintCssClass(string $value): self
    {
        $new = clone $this;
        $new->hintCssClass = $value;
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
     * @param string $type the input type HTML for default its text.
     *
     * @throws ReflectionException
     *
     * @return static
     */
    public function input(array $attributes = []): self
    {
        $new = clone $this;

        Html::addCssClass($attributes, $new->inputCssClass);

        if ($new->ariaDescribedBy === true) {
            $attributes['aria-describedby'] = $new->getId(
                $new->modelInterface->getFormName(),
                $new->attribute,
            ) . '-hint';
        }

        $new->parts['{input}'] = TextInput::widget()
            ->config($new->modelInterface, $new->attribute, $attributes)
            ->invalidCssClass($new->invalidCssClass)
            ->validCssClass($new->validCssClass) . PHP_EOL;

        return $new;
    }

    public function inputCssClass(string $value): self
    {
        $new = clone $this;
        $new->inputCssClass = $value;
        return $new;
    }

    public function invalidCssClass(string $value): self
    {
        $new = clone $this;
        $new->invalidCssClass = $value;
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
            Html::addCssClass($attributes, $new->labelCssClass);

            $new->parts['{label}'] = Label::widget()
                ->config($new->modelInterface, $new->attribute, $attributes)
                ->label($label) . "\n";
        }

        return $new;
    }

    public function labelCssClass(string $value): self
    {
        $new = clone $this;
        $new->labelCssClass = $value;
        return $new;
    }


    public function noHint(): self
    {
        $new = clone $this;
        $new->noHint = true;
        return $new;
    }

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
     * they are explicitly specified in `$options`.
     *
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     *
     * If you set a custom `id` for the input element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @return static.
     */
    public function passwordInput(array $attributes = []): self
    {
        $new = clone $this;

        Html::addCssClass($attributes, $new->inputCssClass);

        if ($new->ariaDescribedBy === true) {
            $attributes['aria-describedby'] = $new->getId(
                $new->modelInterface->getFormName(),
                $new->attribute,
            ) . '-hint';
        }

        $new->parts['{input}'] = PasswordInput::widget()
            ->config($new->modelInterface, $new->attribute, $attributes)
            ->invalidCssClass($new->invalidCssClass)
            ->validCssClass($new->validCssClass) . PHP_EOL;

        return $new;
    }

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
     * @return static the field object itself.
     */
    public function textArea(array $attributes = []): self
    {
        $new = clone $this;

        $new->parts['{input}'] = TextArea::widget()
            ->config($new->modelInterface, $new->attribute, $attributes)
            ->render();

        return $new;
    }

    public function validCssClass(string $value): self
    {
        $new = clone $this;
        $new->validCssClass = $value;
        return $new;
    }
}
