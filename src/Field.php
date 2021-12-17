<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Stringable;
use Yii\Extension\Simple\Forms\Attribute\FieldAttributes;
use Yii\Extension\Simple\Forms\Attribute\GlobalAttributes;
use Yii\Extension\Simple\Model\FormModelInterface;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;

use function strtr;

/**
 * Renders the field widget along with label and hint tag (if any) according to template.
 */
final class Field extends FieldAttributes
{
    /** @psalm-var GlobalAttributes[] */
    private array $buttons = [];
    private array $parts = [];
    private string $template = "{label}\n{input}\n{hint}\n{error}";
    private AbstractWidget $widget;

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
     * Renders a password widget.
     *
     * @param FormModelInterface $formModel the model object.
     * @param string $attribute the attribute name or expression.
     * @param array $config The config for the factory widget.
     *
     * @return static the field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotInstantiableException|NotFoundException
     */
    public function password(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new->widget = $config !== []
            ? Password::widget($config)->for($formModel, $attribute) : Password::widget()->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a reset button widget.
     *
     * @param array $config The config for the factory widget.
     *
     * @return static The field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function resetButton(array $config = []): self
    {
        $new = clone $this;
        $new->buttons[] = $config !== [] ? ResetButton::widget($config) : ResetButton::widget();
        return $new;
    }

    /**
     * Renders a submit button widget.
     *
     * @param array $config The config for the factory widget.
     *
     * @return static The field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function submitButton(array $config = []): self
    {
        $new = clone $this;
        $new->buttons[] = $config !== [] ? SubmitButton::widget($config) : SubmitButton::widget();
        return $new;
    }

    /**
     * Renders a text widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config The config for the factory widget.
     *
     * @return static The field widget instance.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function text(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new->widget = $config !== []
            ? Text::widget($config)->for($formModel, $attribute) : Text::widget()->for($formModel, $attribute);
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
     * @param array $config The config for the factory widget.
     *
     * @return static The field widget instance.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function url(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new->widget = $config !== []
            ? Url::widget($config)->for($formModel, $attribute) : Url::widget()->for($formModel, $attribute);
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
        $new = clone $this;
        $div = Div::tag();
        $content = '';

        if ($new->containerClass !== '') {
            $div = $div->class($new->containerClass);
        }

        if (!empty($new->widget)) {
            $content .= $new->renderField();
        }

        $renderButtons = $new->renderButtons();

        if ($renderButtons !== '') {
            $content .= $renderButtons;
        }

        return $new->container ? $content : $div->content(PHP_EOL . $content . PHP_EOL)->encode(false)->render();
    }

    private function buildField(): self
    {
        $new = clone $this;

        // set ariadescribedby.
        if ($new->ariaDescribedBy === true) {
            $new->widget = $new->widget->ariaDescribedBy($new->widget->getAttribute() . 'Help');
        }

        // set arialabel.
        if ($new->ariaLabel !== '') {
            $new->widget = $new->widget->ariaLabel($new->ariaLabel);
        }

        // set input class.
        if ($new->inputClass !== '' && !array_key_exists('class', $new->widget->getAttributes())) {
            $new->widget = $new->widget->inputClass($new->inputClass);
        }

        // set placeholder.
        $new->placeHolder ??= $new->widget->getAttributePlaceHolder();

        if (!empty($new->placeHolder)) {
            $new->widget = $new->widget->placeHolder($new->placeHolder);
        }

        // set valid class and invalid class.
        if ($new->invalidClass !== '' && $new->widget->hasError()) {
            $new->widget = $new->widget->inputClass($new->invalidClass);
        } elseif ($new->validClass !== '' && $new->widget->isValidated()) {
            $new->widget = $new->widget->inputClass($new->validClass);
        }

        return $new;
    }

    private function renderButtons(): string
    {
        $new = clone $this;
        $buttons = '';

        foreach ($new->buttons as $key => $button) {
            /** @var array */
            $buttonsAttributes = $new->buttonsIndividualAttributes[$key] ?? $new->attributes;
            $buttons .= $button->attributes($buttonsAttributes)->render();
        }

        return $buttons;
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    private function renderError(): string
    {
        $new = clone $this;

        if ($new->error === '') {
            $new->error = $new->widget->getFirstError();
        }

        return Error::widget()
            ->attributes($new->errorAttributes)
            ->encode($new->encode)
            ->message($new->error)
            ->tag($new->errorTag)
            ->render();
    }

    private function renderField(): string
    {
        $new = clone $this;

        $new = $new->setGlobalAttributesField();
        $new = $new->buildField();
        $new->parts['{input}'] = $new->widget->render();
        $new->parts['{label}'] = $new->renderLabel();
        $new->parts['{error}'] = $new->renderError();
        $new->parts['{hint}'] = $new->renderHint();

        return preg_replace('/^\h*\v+/m', '', trim(strtr($new->template, $new->parts)));
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    private function renderHint(): string
    {
        $new = clone $this;
        $hint = Hint::widget()->attributes($new->hintAttributes)->encode($new->encode)->tag($new->hintTag);

        if ($new->ariaDescribedBy === true) {
            $hint = $hint->id($new->widget->getAriaDescribedBy());
        }

        if ($new->hint === '') {
            $new->hint = $new->widget->getAttributeHint();
        }

        return $hint->hint($new->hint === '' ? null : $new->hint)->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    private function renderLabel(): string
    {
        $new = clone $this;

        $label = Label::widget()->attributes($new->labelAttributes)->encode($new->encode);

        if ($new->label === '') {
            $new->label = $new->getAttributeLabel($new->widget->getFormModel(), $new->widget->getAttribute());
        }

        if (!array_key_exists('for', $new->labelAttributes)) {
            /** @var string */
            $for = ArrayHelper::getValue($new->attributes, 'id', $new->widget->getInputId());
            $label = $label->forId($for);
        }

        return $label->label($new->label)->render();
    }

    private function setGlobalAttributesField(): self
    {
        $new = clone $this;

        // set global attributes to widget.
        if ($new->attributes !== []) {
            $attributes = array_merge($new->widget->getAttributes(), $new->attributes);
            $new->widget = $new->widget->attributes($attributes);
        }

        return $new;
    }
}
