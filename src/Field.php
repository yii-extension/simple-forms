<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Stringable;
use Yii\Extension\Simple\Forms\Attribute\ButtonAttributes;
use Yii\Extension\Simple\Forms\Attribute\InputAttributes;
use Yii\Extension\Simple\Forms\FieldPart\Error;
use Yii\Extension\Simple\Forms\FieldPart\Hint;
use Yii\Extension\Simple\Forms\FieldPart\Label;
use Yii\Extension\Simple\Forms\Interface\PlaceholderInterface;
use Yii\Extension\Simple\Model\FormModelInterface;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Option;

use function strtr;

/**
 * Renders the field widget along with label and hint tag (if any) according to template.
 */
final class Field extends AbstractField
{
    /** @psalm-var ButtonAttributes[] */
    private array $buttons = [];
    private array $parts = [];
    private string $template = "{label}\n{input}\n{hint}\n{error}";
    private Widget $widget;

    /**
     * Set after input html.
     *
     * @return static
     */
    public function afterInputHtml(string|Stringable $value): self
    {
        $new = clone $this;
        $new->parts['{after}'] = (string)$value;
        return $new;
    }

    /**
     * Set after input html.
     *
     * @return static
     */
    public function beforeInputHtml(string|Stringable $value): self
    {
        $new = clone $this;
        $new->parts['{before}'] = (string)$value;
        return $new;
    }

    /**
     * Renders a checkbox.
     *
     * This method will generate the `checked` tag attribute according to the model attribute value.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config The config array definition for the factory widget.
     * Available methods:
     * [
     *     'enclosedByLabel()' => [false],
     *     'label()' => ['test-text-label']],
     *     'labelAttributes()' => [['class' => 'test-class']],
     *     'uncheckValue()' => ['0'],
     * ]
     *
     * @return static the field widget instance.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotInstantiableException|NotFoundException
     */
    public function checkbox(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;

        /** @var array */
        $enclosedByLabel = $config['enclosedByLabel()'] ?? [true];

        if ($enclosedByLabel !== [false]) {
            $new->parts['{label}'] = '';
        }

        $new->widget = Checkbox::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a list of checkboxes.
     *
     * A checkbox list allows multiple selection, As a result, the corresponding submitted value is an array.
     * The selection of the checkbox list is taken from the value of the model attribute.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config The config array definition for the factory widget.
     * Available methods:
     * [
     *     'containerAttributes()' => [['class' => 'test-class']],
     *     'containerTag()' => ['span'],
     *     'individualItemsAttributes()' => [[1 => ['disabled' => true], 2 => ['class' => 'test-class']],
     *     'items()' => [[1 => 'Female', 2 => 'Male']],
     *     'itemsAttributes()' => [['disabled' => true],
     *     'itemsFormatter()' => [
     *         static function (CheckboxItem $item) {
     *             return $item->checked
     *                 ? "<label><input type='checkbox' name='$item->name' value='$item->value' checked> $item->label</label>"
     *                 : "<label><input type='checkbox' name='$item->name' value='$item->value'> $item->label</label>";
     *         },
     *     ],
     *     'itemsFromValues()' => [[1 => 'Female', 2 => 'Male']],
     *     'separator()' => ['&#9866;'],
     * ]
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field widget instance.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotInstantiableException|NotFoundException
     */
    public function checkboxList(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new->widget = CheckboxList::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a password widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config The config array definition for the factory widget.
     *
     * @return static the field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotInstantiableException|NotFoundException
     */
    public function password(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new->widget = Password::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a radio widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config The config array definition for the factory widget.
     * Available methods:
     * [
     *     'enclosedByLabel()' => [false],
     *     'label()' => ['Email:'],
     *     'labelAttributes()' => [['class' => 'test-class']]
     *     'uncheckValue()' => ['0'],
     * ]
     *
     * @return static the field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotInstantiableException|NotFoundException
     */
    public function radio(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;

        /** @var array */
        $enclosedByLabel = $config['enclosedByLabel()'] ?? [true];

        if ($enclosedByLabel !== [false]) {
            $new->parts['{label}'] = '';
        }

        $new->widget = Radio::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a radio list widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config The config array definition for the factory widget.
     * Available methods:
     * [
     *     'containerAttributes()' => [['class' => 'test-class']],
     *     'containerTag()' => ['span'],
     *     'items()' => [[1 => 'Female', 2 => 'Male']],
     *     'itemsAttributes()' => [['class' => 'test-class']],
     *     'individualItemsAttributes()' => [[1 => ['disabled' => true], 2 => ['class' => 'test-class']]],
     *     'itemsFormatter()' => [
     *         static function (RadioItem $item) {
     *             return $item->checked
     *                 ? "<label><input type='checkbox' name='$item->name' value='$item->value' checked> $item->label</label>"
     *                 : "<label><input type='checkbox' name='$item->name' value='$item->value'> $item->label</label>";
     *         },
     *     ],
     *     'itemsFromValues()' => [[1 => 'Female', 2 => 'Male']],
     *     'separator()' => [PHP_EOL],
     *     'uncheckValue()' => ['0'],
     * ]
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotInstantiableException|NotFoundException
     */
    public function radiolist(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new->widget = RadioList::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a range widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config The config array definition for the factory widget.
     * Available methods:
     * [
     *     'outputTag()' => ['p'],
     *     'outputAttributes()' => [['class' => 'test-class']],
     * ]
     *
     * @return static the field object itself.
     */
    public function range(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new->widget = Range::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a reset button widget.
     *
     * @param array $config The config array definition for the factory widget.
     *
     * @return static The field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function resetButton(array $config = []): self
    {
        $new = clone $this;
        $new->buttons[] = ResetButton::widget($config);
        return $new;
    }

    /**
     * Renders a select widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config The config array definition for the factory widget.
     * Available methods:
     * [
     *     'encode()' => [true],
     *     'groups()' => [['1' => ['2' => ' Moscu', '3' => ' San Petersburgo']]],
     *     'items()' => [['1' => 'Moscu', '2' => 'San Petersburgo']],
     *     'itemsAttributes()' => [['2' => ['disabled' => true]],
     *     'optionsData()' => [['1' => '<b>Moscu</b>', '2' => 'San Petersburgo']],
     *     'prompt()' => 'Select...',
     *     'promptTag()' => [Option::tag()->content('Select City Birth')->value(0)],
     *     'unselectValue()' => ['0'],
     * ]
     *
     * @return static the field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function select(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new->widget = Select::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a submit button widget.
     *
     * @param array $config The config array definition for the factory widget.
     *
     * @return static The field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function submitButton(array $config = []): self
    {
        $new = clone $this;
        $new->buttons[] = SubmitButton::widget($config);
        return $new;
    }

    /**
     * Renders a text widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config The config array definition for the factory widget.
     *
     * @return static The field widget instance.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function text(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new->widget = Text::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a text area.
     *
     * The model attribute value will be used as the content in the textarea.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config The config array definition for the factory widget.
     *
     * @return static the field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function textArea(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new->widget = TextArea::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Set the template for the field.
     *
     * @param string $value The template.
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
     * Renders a url widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config The config array definition for the factory widget.
     *
     * @return static The field widget instance.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function url(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new->widget = Url::widget($config)->for($formModel, $attribute);
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
     * @return string The rendering result.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    protected function run(): string
    {
        $content = '';

        $div = Div::tag();

        if ($this->containerClass !== '') {
            $div = $div->class($this->containerClass);
        }

        if ($this->containerAttributes !== []) {
            $div = $div->attributes($this->containerAttributes);
        }

        if (!empty($this->widget)) {
            $content .= $this->renderField();
        }

        $renderButtons = $this->renderButtons();

        if ($renderButtons !== '') {
            $content .= $renderButtons;
        }

        return $this->container ? $content : $div->content(PHP_EOL . $content . PHP_EOL)->encode(false)->render();
    }

    private function buildField(): self
    {
        $new = clone $this;

        // Set ariadescribedby.
        if ($new->ariaDescribedBy === true && $new->widget instanceof InputAttributes) {
            $new->widget = $new->widget->ariaDescribedBy($new->widget->getAttribute() . 'Help');
        }

        // Set encode.
        $new->widget = $new->widget->encode($new->encode);

        // Set input class.
        if ($new->inputClass !== '') {
            $new->widget = $new->widget->class($new->inputClass);
        }

        // Set label settings for the radio and checkbox fields.
        if ($new->widget instanceof Radio || $new->widget instanceof Checkbox) {
            $new->widget = $new->widget->label($new->label)->labelAttributes($new->labelAttributes);
        }

        // Set placeholder.
        $new->placeHolder ??= $new->widget->getAttributePlaceHolder();

        if (!empty($new->placeHolder) && $new->widget instanceof PlaceholderInterface) {
            $new->widget = $new->widget->placeHolder($new->placeHolder);
        }

        // Set valid class and invalid class.
        if ($new->invalidClass !== '' && $new->widget->hasError()) {
            $new->widget = $new->widget->class($new->invalidClass);
        } elseif ($new->validClass !== '' && $new->widget->isValidated()) {
            $new->widget = $new->widget->class($new->validClass);
        }

        return $new;
    }

    private function renderButtons(): string
    {
        $buttons = '';

        foreach ($this->buttons as $key => $button) {
            /** @var array */
            $buttonsAttributes = $this->buttonsIndividualAttributes[$key] ?? $this->getAttributes();

            // Set input class.
            if ($this->inputClass !== '') {
                $button = $button->class($this->inputClass);
            }

            $buttons .= $button->attributes($buttonsAttributes)->render();
        }

        return $buttons;
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    private function renderError(): string
    {

        $firstError = $this->error ?? '';

        if ($firstError === '') {
            $firstError = $this->widget->getFirstError();
        }

        return Error::widget()
            ->attributes($this->errorAttributes)
            ->encode($this->encode)
            ->message($firstError)
            ->tag($this->errorTag)
            ->render();
    }

    private function renderField(): string
    {
        $new = clone $this;

        $new = $new->setGlobalAttributesField();
        $new = $new->buildField();
        $new->parts['{input}'] = $new->widget->render();
        $new->parts['{error}'] = $new->error !== null ? $new->renderError() : '';
        $new->parts['{hint}'] = $new->renderHint();

        if (!array_key_exists('{label}', $new->parts)) {
            $new->parts['{label}'] = $new->renderLabel();
        }

        return preg_replace('/^\h*\v+/m', '', trim(strtr($new->template, $new->parts)));
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    private function renderHint(): string
    {
        $hint = Hint::widget()->attributes($this->hintAttributes)->encode($this->encode)->tag($this->hintTag);

        if ($this->ariaDescribedBy === true && $this->widget instanceof InputAttributes) {
            $hint = $hint->id($this->widget->getAriaDescribedBy());
        }

        $hintText = $this->hint;

        if ($hintText === '') {
            $hintText = $this->widget->getAttributeHint();
        }

        return $hint->hint($hintText === '' ? null : $hintText)->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    private function renderLabel(): string
    {
        $label = Label::widget()->attributes($this->labelAttributes)->encode($this->encode);

        $attributeLabel = $this->label;

        if ($attributeLabel === '') {
            $attributeLabel = $this->widget->getAttributeLabel();
        }

        if (!array_key_exists('for', $this->labelAttributes)) {
            /** @var string */
            $for = ArrayHelper::getValue($this->getAttributes(), 'id', $this->widget->getInputId());
            $label = $label->forId($for);
        }

        return $label->label($attributeLabel)->render();
    }

    private function setGlobalAttributesField(): self
    {
        $new = clone $this;

        // set global attributes to widget.
        if ($new->getAttributes() !== []) {
            $attributes = array_merge($new->widget->getAttributes(), $new->getAttributes());
            $new->widget = $new->widget->attributes($attributes);
        }

        return $new;
    }
}
