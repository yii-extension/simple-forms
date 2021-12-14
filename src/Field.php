<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Stringable;
use Yii\Extension\Simple\Model\FormModelInterface;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Validator\Rule;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\MatchRegularExpression;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Url as UrlValidator;
use Yiisoft\Widget\Widget;

use function strtr;

/**
 * Renders the field widget along with label and hint tag (if any) according to template.
 */
final class Field extends Widget
{
    private string $ariaLabel = '';
    private bool $ariaDescribedBy = false;
    private string $containerClass = '';
    private string $error = '';
    private array $errorAttributes = [];
    private string $errorClass = '';
    private string $errorTag = 'div';
    private string $inputClass = '';
    private string $invalidClass = '';
    private string $hint = '';
    private string $hintClass = '';
    private array $hintAttributes = [];
    private string $hintTag = 'div';
    private string $label = '';
    private array $labelAttributes = [];
    private string $labelClass = '';
    private array $parts = [];
    private string|null $placeHolder = null;
    private string $template = "{label}\n{input}\n{hint}\n{error}";
    private string $validClass = '';
    private AbstractWidget $widget;

    /**
     * Set aria-describedby attribute.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/WCAG20-TECHS/ARIA1.html
     */
    public function ariaDescribedBy(): self
    {
        $new = clone $this;
        $new->ariaDescribedBy = true;
        return $new;
    }

    public function ariaLabel(string $value): self
    {
        $new = clone $this;
        $new->ariaLabel = $value;
        return $new;
    }

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

    public function containerClass(string $value): self
    {
        $new = clone $this;
        $new->containerClass = $value;
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
     * Renders a password widget.
     *
     * @param FormModelInterface $formModel the model object.
     * @param string $attribute the attribute name or expression.
     * @param array $attributes the HTML attributes for the widget.
     * Most used attributes:
     * [
     *     'maxlength' => 16,
     *     'minlength' => 8,
     *     'pattern' => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}',
     *     'title' => 'Must contain at least one number and one uppercase and lowercase letter, and at ' .
     *                'least 8 or more characters.',
     *     'readonly' => true
     * ]
     *
     * @return static the field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotInstantiableException|NotFoundException
     */
    public function password(FormModelInterface $formModel, string $attribute, array $attributes = []): self
    {
        $new = clone $this;
        $new->widget = Password::widget()->for($formModel, $attribute)->attributes($attributes);
        return $new;
    }

    public function placeHolder(?string $value): self
    {
        $new = clone $this;
        $new->placeHolder = $value;
        return $new;
    }

    /**
     * Renders a reset button widget.
     *
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function resetButton(array $attributes = []): self
    {
        $new = clone $this;
        $new->widget = ResetButton::widget()->attributes($attributes);
        return $new;
    }

    /**
     * Renders a submit button widget.
     *
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function submitButton(array $attributes = []): self
    {
        $new = clone $this;
        $new->widget = SubmitButton::widget()->attributes($attributes);
        return $new;
    }

    /**
     * Renders a text widget.
     *
     * @param FormModelInterface $formModel the model object.
     * @param string $attribute the attribute name or expression.
     * @param array $attributes the HTML attributes for the widget.
     * Most used attributes:
     * [
     *     'dirname' => 'my-dir',
     *     'maxlength' => 10,
     *     'placeholder' => 'Enter your name',
     *     'pattern' => '\d+',
     *     'readonly' => true,
     * ]
     *
     * @return static the field widget instance.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function text(FormModelInterface $formModel, string $attribute, array $attributes = []): self
    {
        $new = clone $this;
        $new->widget = Text::widget()->for($formModel, $attribute)->attributes($attributes);
        return $new;
    }

    public function template(string $value): self
    {
        $new = clone $this;
        $new->template = $value;
        return $new;
    }

    /**
     * Renders a url widget.
     *
     * @param FormModelInterface $formModel the model object.
     * @param string $attribute the attribute name or expression.
     * @param array $attributes the HTML attributes for the widget.
     * Most used attributes:
     * [
     *     'maxlength' => 10,
     *     'minlength' => 5,
     *     'pattern' => '\d+',
     *     'size' => 5,
     * ]
     *
     * @return static the field widget instance.
     */
    public function url(FormModelInterface $formModel, string $attribute, array $attributes = []): self
    {
        $new = clone $this;
        $new->widget = Url::widget()->for($formModel, $attribute)->attributes($attributes);
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
     * @return string the rendering result.
     */
    protected function run(): string
    {
        $new = clone $this;

        $div = Div::tag();

        $new = $new->buildField();

        $new->parts['{input}'] = $new->widget->render();
        $new->parts['{error}'] = $new->renderError();
        $new->parts['{hint}'] = $new->renderHint();
        $new->parts['{label}'] = $new->renderLabel();

        if ($new->containerClass !== '') {
            $div = $div->class($new->containerClass);
        }

        $content = preg_replace('/^\h*\v+/m', '', trim(strtr($new->template, $new->parts)));

        return $div->content(PHP_EOL . $content . PHP_EOL)->encode(false)->render();
    }

    private function buildField(): self
    {
        $new = clone $this;

        // set ariadescribedby.
        if ($new->ariaDescribedBy === true) {
            $attributes = $new->widget->getAttributes();
            /** @var string */
            $attributes['id'] ??= $new->widget->getInputId();
            $new->widget = $new->widget->ariaDescribedBy($attributes['id']);
        }

        // set arialabel.
        if ($new->ariaLabel !== '') {
            $new->widget = $new->widget->ariaLabel($new->ariaLabel);
        }

        // set input class.
        if ($new->inputClass !== '') {
            $new->widget = $new->widget->addClass($new->inputClass);
        }

        // set placeholder.
        $new->placeHolder ??= $new->widget->getAttributePlaceHolder();

        if ($new->placeHolder !== '') {
            $new->widget = $new->widget->placeHolder($new->placeHolder);
        }

        // set valid class and invalid class.
        if ($new->invalidClass !== '' && $new->widget->hasError()) {
            $new->widget = $new->widget->addClass($new->invalidClass);
        } elseif ($new->validClass !== '' && $new->widget->isValidated()) {
            $new->widget = $new->widget->addClass($new->validClass);
        }

        $new->checkValidator();

        return $new;
    }

    private function getSchemePattern(string $scheme): string
    {
        $result = '';
        for ($i = 0, $length = mb_strlen($scheme); $i < $length; $i++) {
            $result .= '[' . mb_strtolower($scheme[$i]) . mb_strtoupper($scheme[$i]) . ']';
        }
        return $result;
    }

    private function checkHasLengthValidator(Rule $rule): void
    {
        if ($rule instanceof HasLength && $this->widget instanceof HasLengthInterface) {
            $this->widget->maxlength((int)$rule->getOptions()['max']);
            $this->widget->minlength((int)$rule->getOptions()['min']);
        }
    }

    private function checkMatchRegularExpression(Rule $rule): void
    {
        if ($rule instanceof MatchRegularExpression && $this->widget instanceof MatchRegularInterface) {
            /** @var string */
            $pattern = $rule->getOptions()['pattern'];
            $this->widget->pattern(Html::normalizeRegexpPattern($pattern));
        }
    }

    private function checkNumberValidator(Rule $rule): void
    {
        if ($rule instanceof Number && $this->widget instanceof NumberInterface) {
            /** @var string */
            $this->widget->max((int)$rule->getOptions()['max']);
            /** @var string */
            $this->widget->min((int)$rule->getOptions()['min']);
        }
    }

    private function checkRequiredValidator(Rule $rule): void
    {
        if ($rule instanceof Required) {
            $this->widget->required();
        }
    }

    private function checkUrlValidator(Rule $rule): void
    {
        if ($rule instanceof UrlValidator && $this->widget instanceof Url) {
            /** @var array<array-key, string> */
            $validSchemes = $rule->getOptions()['validSchemes'];

            $schemes = [];

            foreach ($validSchemes as $scheme) {
                $schemes[] = $this->getSchemePattern($scheme);
            }

            /** @var array<array-key, float|int|string>|string */
            $pattern = $rule->getOptions()['pattern'];
            $normalizePattern = str_replace('{schemes}', '(' . implode('|', $schemes) . ')', $pattern);
            $this->widget->pattern(Html::normalizeRegexpPattern($normalizePattern));
        }
    }

    private function checkValidator(): void
    {
        $new = clone $this;

        /** @psalm-var array<array-key,Rule> */
        $rules = $new->widget->getFormModel()->getRules()[$new->widget->getAttribute()] ?? [];

        foreach ($rules as $rule) {
            $new->checkRequiredValidator($rule);
            $new->checkHasLengthValidator($rule);
            $new->checkMatchRegularExpression($rule);
            $new->checkNumberValidator($rule);
            $new->checkUrlValidator($rule);
        }
    }

    private function renderError(): string
    {
        $new = clone $this;

        if ($new->errorClass !== '') {
            Html::addCssClass($new->errorAttributes, $new->errorClass);
        }

        if ($new->error === '') {
            $new->error = $new->widget->getFirstError();
        }

        return Error::widget()
            ->attributes($new->errorAttributes)
            ->encode($new->widget->getEncode())
            ->message($new->error)
            ->tag($new->errorTag)
            ->render();
    }

    private function renderHint(): string
    {
        $new = clone $this;

        if ($new->ariaDescribedBy === true) {
            $new->hintAttributes['id'] ??= $new->widget->getInputId();
        }

        if ($new->hintClass !== '') {
            Html::addCssClass($new->hintAttributes, $new->hintClass);
        }

        if ($new->hint === '') {
            $new->hint = $new->widget->getAttributeHint();
        }

        return Hint::widget()
            ->attributes($new->hintAttributes)
            ->encode($new->widget->getEncode())
            ->hint($new->hint === '' ? null : $new->hint)
            ->tag($new->hintTag)
            ->render();
    }

    private function renderLabel(): string
    {
        $new = clone $this;

        if ($new->labelClass !== '') {
            Html::addCssClass($new->labelAttributes, $new->labelClass);
        }

        if ($new->label === '') {
            $new->label = $new->widget->getAttributeLabel();
        }

        $new->labelAttributes['for'] ??= $new->widget->getInputId();

        return Label::widget()
            ->attributes($new->labelAttributes)
            ->encode($new->widget->getEncode())
            ->label($new->label)
            ->render();
    }
}
