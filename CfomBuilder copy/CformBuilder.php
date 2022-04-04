<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Stringable;
use Yii\Extension\Simple\Model\Helper\HtmlForm;
use Yii\Extension\Simple\Model\Helper\HtmlFormErrors;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Http\Method;

use function explode;
use function implode;
use function strpos;
use function substr;
use function urldecode;

/**
 *  Generates a form start tag.
 *
 *  @link https://www.w3.org/TR/html52/sec-forms.html
 */
final class CformBuilder extends AbstractForm
{
    private string $action = '';
    /** @psalm-var array<string, AbstractWidget> */
    private array $buttons = [];
    private string $csrfName = '';
    private string $csrfToken = '';
    private array $errorAttributes = [];
    private string $errorClass = '';
    private string $errorTag = 'div';
    private string $footerForm = '';
    private string $headerForm = '';
    /** @psalm-var string[] */
    private array $individualContainerClass = [];
    /** @psalm-var string[] */
    private array $individualErrorClass = [];
    /** @psalm-var string[] */
    private array $individualErrorText = [];
    /** @psalm-var string[] */
    private array $individualHintClass = [];
    /** @psalm-var string[] */
    private array $individualInputHtml = [];
    /** @psalm-var string[] */
    private array $individualHintText = [];
    /** @psalm-var string[] */
    private array $individualInputClass = [];
    /** @psalm-var string[] */
    private array $individualLabelClass = [];
    /** @psalm-var string[] */
    private array $individualLabelTag = [];
    /** @psalm-var string[] */
    private array $individualLabelText = [];
    /** @psalm-var string[] */
    private array $individualTemplateField = [];
    private array $hintAttributes = [];
    private string $hintClass = '';
    private string $hintTag = 'div';
    private string $id = '';
    private string $inputClass = '';
    private array $labelAttributes = [];
    private string $labelClass = '';
    private string $method = Method::POST;
    private array $parts = [];
    private array $partsForm = [];
    private string $templateField = "{label}\n{input}\n{hint}\n{error}";
    private string $templateForm = "{form}\n{buttons}";
    /** @psalm-var array<array-key, AbstractWidget|string|Stringable> */
    private array $widgets = [];

    /**
     * The action and formaction content attributes, if specified, must have a value that is a valid non-empty URL
     * potentially surrounded by spaces.
     *
     * @param string $value the action attribute value.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-action
     */
    public function action(string $value): self
    {
        $new = clone $this;
        $new->action = $value;
        return $new;
    }

    /**
     * @param AbstractWidget $buttons
     */
    public function addButtons(...$buttons): self
    {
        $new = clone $this;

        foreach ($buttons as $button) {
            $new->buttons[get_class($button)] = $button;
        }

        return $new;
    }

    /**
     * @param AbstractWidget|string|Stringable $widgets
     */
    public function addFields(...$widgets): self
    {
        $new = clone $this;

        foreach ($widgets as $widget) {
            if ($widget instanceof AbstractWidget) {
                $new->widgets[$widget->getAttribute()] = $widget;
            } else {
                $new->widgets[] = (string) $widget;
            }
        }

        return $new;
    }

    /**
     * @return string the generated form start tag.
     *
     * {@see end())}
     */
    public function begin(): ?string
    {
        return null;
    }

    /**
     * The CSRF-token content attribute token that are known to be safe to use for.
     *
     * @param mixed|string|Stringable $csrfToken the CSRF-token attribute value.
     * @param string $csrfName the CSRF-token attribute name.
     *
     * @return static
     */
    public function csrf($csrfToken, string $csrfName = '_csrf'): self
    {
        $new = clone $this;

        if (is_string($csrfToken) || (is_object($csrfToken) && method_exists($csrfToken, '__toString'))) {
            $new->csrfToken = (string) $csrfToken;
        } else {
            throw new InvalidArgumentException('$csrfToken must be a string or \Stringable object.');
        }

        $new->csrfName = $csrfName;
        return $new;
    }

    public function errorAttributes(array $value): self
    {
        $new = clone $this;
        $new->errorAttributes = $value;
        return $new;
    }

    public function errorClass(string $value): self
    {
        $new = clone $this;
        $new->errorClass = $value;
        return $new;
    }

    public function errorTag(string $value): self
    {
        $new = clone $this;
        $new->errorTag = $value;
        return $new;
    }

    public function footerForm(string $value): self
    {
        $new = clone $this;
        $new->footerForm = $value;
        return $new;
    }

    public function headerForm(string $value): self
    {
        $new = clone $this;
        $new->headerForm = $value;
        return $new;
    }

    public function hintAttributes(array $value): self
    {
        $new = clone $this;
        $new->hintAttributes = $value;
        return $new;
    }

    public function hintClass(string $value): self
    {
        $new = clone $this;
        $new->hintClass = $value;
        return $new;
    }

    public function individualContainerClass(array $value): self
    {
        $new = clone $this;
        $new->individualContainerClass = $value;
        return $new;
    }

    public function individualErrorText(array $value): self
    {
        $new = clone $this;
        $new->individualErrorText = $value;
        return $new;
    }

    public function individualHintClass(array $value): self
    {
        $new = clone $this;
        $new->individualHintClass = $value;
        return $new;
    }

    public function individualHintText(array $value): self
    {
        $new = clone $this;
        $new->individualHintText = $value;
        return $new;
    }

    public function individualInputClass(array $value): self
    {
        $new = clone $this;
        $new->individualInputClass = $value;
        return $new;
    }

    public function individualInputHtml(array $value): self
    {
        $new = clone $this;
        $new->individualInputHtml = $value;
        return $new;
    }

    public function individualLabelClass(array $value): self
    {
        $new = clone $this;
        $new->individualLabelClass = $value;
        return $new;
    }

    public function individualLabelText(array $value): self
    {
        $new = clone $this;
        $new->individualLabelText = $value;
        return $new;
    }

    public function individualTemplateField(array $value): self
    {
        $new = clone $this;
        $new->individualTemplateField = $value;
        return $new;
    }

    public function inputClass(string $value): self
    {
        $new = clone $this;
        $new->inputClass = $value;
        return $new;
    }

    public function labelAttributes(array $values): self
    {
        $new = clone $this;
        $new->labelAttributes = $values;
        return $new;
    }

    public function labelClass(string $value): self
    {
        $new = clone $this;
        $new->labelClass = $value;
        return $new;
    }

    /**
     * The method content attribute specifies how the form-data should be submitted.
     *
     * @param string $value the method attribute value.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-method
     */
    public function method(string $value): self
    {
        $new = clone $this;
        $new->method = strtoupper($value);
        return $new;
    }

    public function templateField(string $value): self
    {
        $new = clone $this;
        $new->templateField = $value;
        return $new;
    }

    public function templateForm(string $value): self
    {
        $new = clone $this;
        $new->templateForm = $value;
        return $new;
    }

    /**
     * @return string the generated form start tag.
     *
     * {@see end())}
     */
    protected function run(): string
    {
        $new = clone $this;
        $hiddenInputs = [];

        /** @var string */
        $new->attributes['id'] ??= Html::generateId('w') . '-form';

        if ($new->csrfToken !== '' && $new->method === Method::POST) {
            $hiddenInputs[] = Html::hiddenInput($new->csrfName, $new->csrfToken);
        }

        if ($new->method === Method::GET && ($pos = strpos($new->action, '?')) !== false) {
            /**
             * Query parameters in the action are ignored for GET method we use hidden fields to add them back.
             */
            foreach (explode('&', substr($new->action, $pos + 1)) as $pair) {
                if (($pos1 = strpos($pair, '=')) !== false) {
                    $hiddenInputs[] = Html::hiddenInput(
                        urldecode(substr($pair, 0, $pos1)),
                        urldecode(substr($pair, $pos1 + 1))
                    );
                } else {
                    $hiddenInputs[] = Html::hiddenInput(urldecode($pair), '');
                }
            }

            $new->action = substr($new->action, 0, $pos);
        }

        if ($new->action !== '') {
            $new->attributes['action'] = $new->action;
        }

        $new->attributes['method'] = $new->method;

        if ($new->csrfToken !== '') {
            $new->attributes[$new->csrfName] = $new->csrfToken;
        }

        $formBegin = Html::openTag('form', $new->attributes);
        $formEnd = Html::closeTag('form');

        if (!empty($hiddenInputs)) {
            $formBegin .= PHP_EOL . implode(PHP_EOL, $hiddenInputs);
        }

        $new = $new->buildFields();
        $new->partsForm['{form}'] = $new->renderFields();
        $new->partsForm['{buttons}'] = $new->renderButtons();

        $contentForm = '';

        if ($new->headerForm !== '') {
            $contentForm .= $new->headerForm . PHP_EOL;
        }

        $contentForm .= preg_replace('/^\h*\v+/m', '', trim(strtr($new->templateForm, $new->partsForm)));

        if ($new->footerForm !== '') {
            $contentForm .= PHP_EOL . $new->footerForm;
        }

        return $contentForm !== '' ? $formBegin . PHP_EOL . $contentForm . PHP_EOL . $formEnd : $formBegin . $formEnd;
    }

    private function renderButtons(): string
    {
        $new = clone $this;
        $html = '';

        foreach ($new->buttons as $button) {
            $html .= $button->render() . PHP_EOL;
        }

        return $new->getWithoutButtonsContainer() === false && $html !== ''
            ? Div::tag()
                ->class($new->getButtonsClass())
                ->content(PHP_EOL . $html)
                ->encode($new->getEncode())
                ->render()
            : $html;
    }

    private function buildFields(): self
    {
        $new = clone $this;

        foreach ($new->widgets as $key => $widget) {
            if ($widget instanceof AbstractWidget && isset($new->individualInputClass[$widget->getAttribute()])) {
                $new->widgets[$key] = $widget->addClass($new->individualInputClass[$widget->getAttribute()]);
            } elseif ($widget instanceof AbstractWidget && $new->inputClass !== '') {
                $new->widgets[$key] = $widget->addClass($new->inputClass);
            } else {
                $new->widgets[$key] = $widget;
            }
        }

        return $new;
    }

    private function getWidgetId(AbstractWidget $widget): string
    {
        $attributes = $widget->getAttributes();
        return $attributes['$id'] ??= $this->getInputId($widget);
    }

    private function getWidgetName(AbstractWidget $widget): string
    {
        $attributes = $widget->getAttributes();
        return $attributes['name'] ??= $this->getInputName($widget);
    }

    private function renderError(AbstractWidget $widget): string
    {
        $new = clone $this;

        if (isset($new->individualErrorClass[$widget->getAttribute()])) {
            Html::addCssClass($new->errorAttributes, $new->individualErrorClass[$widget->getAttribute()]);
        } elseif ($new->errorClass !== '') {
            Html::addCssClass($new->labelAttributes, $new->errorClass);
        }

        $error = $new->individualErrorText[$widget->getAttribute()] ?? '';

        if ($error === '') {
            $error = $new->getFirstError($widget);
        }

        return Error::widget()
            ->attributes($new->errorAttributes)
            ->encode($new->getEncode())
            ->for($widget->getFormModel(), $widget->getAttribute())
            ->message($error)
            ->tag($new->errorTag)
            ->render();
    }

    private function renderFields(): string
    {
        $html = '';

        $new = clone $this;

        foreach ($new->widgets as $key => $widget) {
            if ($widget instanceof AbstractWidget) {
                $new->parts['{input}'] = $widget->run();
                $new->parts['{label}'] = $new->renderLabel($widget);
                $new->parts['{hint}'] = $new->renderHint($widget);
                $new->parts['{error}'] = $new->renderError($widget);
                $new->parts['{inputHtml}'] = $new->individualInputHtml[$key] ?? '';

                if (isset($new->individualTemplateField[$key])) {
                    $content = preg_replace(
                        '/^\h*\v+/m',
                        '',
                        trim(strtr($new->individualTemplateField[$key], $new->parts)),
                    );
                } else {
                    $content = preg_replace('/^\h*\v+/m', '', trim(strtr($new->templateField, $new->parts)));
                }

                /** @var string */
                $containerClass = $new->individualContainerClass[$key] ?? $new->getContainerClass();

                $html .= $new->getWithoutContainer() === false
                    ? Div::tag()
                        ->class($containerClass)
                        ->content(PHP_EOL . $content . PHP_EOL)
                        ->encode($new->getEncode())
                        ->render() . PHP_EOL
                    : $content;
            } else {
                $html .= $widget . PHP_EOL;
            }
        }

        return $html;
    }

    private function renderHint(AbstractWidget $widget): string
    {
        $new = clone $this;

        if ($new->getAriaDescribedBy() === true) {
            $new->hintAttributes['id'] ??= $new->getInputId();
        }

        if (isset($new->individualHintClass[$widget->getAttribute()])) {
            Html::addCssClass($new->hintAttributes, $new->individualHintClass[$widget->getAttribute()]);
        } elseif ($new->hintClass !== '') {
            Html::addCssClass($new->hintAttributes, $new->hintClass);
        }

        /** @var string|null */
        $hint = ArrayHelper::getValue($new->individualHintText, $widget->getAttribute(), '');

        if ($hint === '') {
            $hint = $new->getAttributeHint($widget);
        }

        return Hint::widget()
            ->attributes($new->hintAttributes)
            ->encode($new->getEncode())
            ->for($widget->getFormModel(), $widget->getAttribute())
            ->hint($hint === '' ? null : $hint)
            ->tag($new->hintTag)
            ->render();
    }

    private function renderLabel(AbstractWidget $widget): string
    {
        $new = clone $this;

        if (isset($new->individualLabelClass[$widget->getAttribute()])) {
            Html::addCssClass($new->labelAttributes, $new->individualLabelClass[$widget->getAttribute()]);
        } elseif ($new->labelClass !== '') {
            Html::addCssClass($new->labelAttributes, $new->labelClass);
        }

        /** @var string|null */
        $label = ArrayHelper::getValue($new->individualLabelText, $widget->getAttribute(), '');

        if ($label === '') {
            $label = $new->getAttributeLabel($widget);
        }

        return Label::widget()
            ->attributes($new->labelAttributes)
            ->encode($new->getEncode())
            ->for($widget->getFormModel(), $widget->getAttribute())
            ->label($label)
            ->render();
    }
}
