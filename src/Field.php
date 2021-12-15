<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Stringable;
use Yii\Extension\Simple\Model\FormModelInterface;
use Yiisoft\Arrays\ArrayHelper;
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
final class Field extends AbstractField
{
    private string $ariaLabel = '';
    private bool $ariaDescribedBy = false;
    private string $containerClass = '';
    private bool $encode = true;
    private string $error = '';
    private array $errorAttributes = [];
    private string $errorClass = '';
    private string $errorTag = 'div';
    private string $inputClass = '';
    private string $invalidClass = '';
    private string|null $hint = '';
    private string $hintClass = '';
    private array $hintAttributes = [];
    private string $hintTag = 'div';
    private string|null $label = '';
    private array $labelAttributes = [];
    private string $labelClass = '';
    private array $parts = [];
    private string|null $placeHolder = null;
    private string $template = "{label}\n{input}\n{hint}\n{error}";
    private string $validClass = '';
    /** @var AbstractWidget|AbstractForm */
    private $widget;

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

    public function encode(bool $value): self
    {
        $new = clone $this;
        $new->encode = $value;
        return $new;
    }

    public function errorClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->errorAttributes, $value);
        return $new;
    }

    public function hint(string $value): self
    {
        $new = clone $this;
        $new->hint = $value;
        return $new;
    }

    public function hintClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->hintAttributes, $value);
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

    public function label(string $value): self
    {
        $new = clone $this;
        $new->label = $value;
        return $new;
    }

    public function labelClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->labelAttributes, $value);
        return $new;
    }

    public function labelFor(string $value): self
    {
        $new = clone $this;
        $new->labelAttributes['for'] = $value;
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

    public function withoutHint(): self
    {
        $new = clone $this;
        $new->hint = null;
        return $new;
    }

    public function withoutLabel(): self
    {
        $new = clone $this;
        $new->label = null;
        return $new;
    }

    public function withoutLabelFor(): self
    {
        $new = clone $this;
        $new->labelAttributes['for'] = null;
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

        $new = $new->setGlobalAttributes();

        $new = $new->buildField();
        $new->parts['{input}'] = $new->widget->render();

        if ($new->widget instanceof AbstractWidget) {
            $new->parts['{error}'] = $new->renderError();
            $new->parts['{hint}'] = $new->renderHint();
            $new->parts['{label}'] = $new->renderLabel();
        }

        if ($new->widget instanceof AbstractForm) {
            $new = $new->template('{input}');
        }

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
        if ($new->ariaDescribedBy === true && $new->widget instanceof AbstractWidget) {
            $attributes = $new->widget->getAttributes();
            /** @var string */
            $attributes['id'] ??= $new->widget->getInputId();
            $new->widget = $new->widget->ariaDescribedBy($attributes['id']);
        }

        // set arialabel.
        if ($new->ariaLabel !== '' && $new->widget instanceof AbstractWidget) {
            $new->widget = $new->widget->ariaLabel($new->ariaLabel);
        }

        // set input class.
        if ($new->inputClass !== '' && $new->widget instanceof AbstractWidget) {
            $new->widget = $new->widget->addClass($new->inputClass);
        }

        // set placeholder.
        if ($new->widget instanceof AbstractWidget) {
            $new->placeHolder ??= $new->widget->getAttributePlaceHolder();
        }

        if (!empty($new->placeHolder) && $new->widget instanceof AbstractWidget) {
            $new->widget = $new->widget->placeHolder($new->placeHolder);
        }

        // set valid class and invalid class.
        if ($new->invalidClass !== '' && $new->widget instanceof AbstractWidget && $new->widget->hasError()) {
            $new->widget = $new->widget->addClass($new->invalidClass);
        } elseif ($new->validClass !== '' && $new->widget instanceof AbstractWidget && $new->widget->isValidated()) {
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

    private function checkValidator(): void
    {
        $new = clone $this;
        $rules = [];

        if ($new->widget instanceof AbstractWidget) {
            /** @psalm-var array<array-key,Rule> */
            $rules = $new->widget->getFormModel()->getRules()[$new->widget->getAttribute()] ?? [];
        }

        foreach ($rules as $rule) {
            if ($rule instanceof Required && $new->widget instanceof AbstractWidget) {
                $new->widget->required();
            }

            if ($rule instanceof HasLength && $new->widget instanceof HasLengthInterface) {
                $new->widget->maxlength((int)$rule->getOptions()['max']);
                $new->widget->minlength((int)$rule->getOptions()['min']);
            }

            if ($rule instanceof MatchRegularExpression && $new->widget instanceof MatchRegularInterface) {
                /** @var string */
                $pattern = $rule->getOptions()['pattern'];
                $new->widget->pattern(Html::normalizeRegexpPattern($pattern));
            }

            if ($rule instanceof Number && $new->widget instanceof NumberInterface) {
                /** @var string */
                $new->widget->max((int)$rule->getOptions()['max']);
                /** @var string */
                $new->widget->min((int)$rule->getOptions()['min']);
            }

            if ($rule instanceof UrlValidator && $new->widget instanceof Url) {
                /** @var array<array-key, string> */
                $validSchemes = $rule->getOptions()['validSchemes'];

                $schemes = [];

                foreach ($validSchemes as $scheme) {
                    $schemes[] = $this->getSchemePattern($scheme);
                }

                /** @var array<array-key, float|int|string>|string */
                $pattern = $rule->getOptions()['pattern'];
                $normalizePattern = str_replace('{schemes}', '(' . implode('|', $schemes) . ')', $pattern);
                $new->widget->pattern(Html::normalizeRegexpPattern($normalizePattern));
            }
        }
    }

    private function renderError(): string
    {
        $new = clone $this;

        if ($new->error === '' && $new->widget instanceof AbstractWidget) {
            $new->error = $new->widget->getFirstError();
        }

        return Error::widget()
            ->attributes($new->errorAttributes)
            ->encode($new->encode)
            ->message($new->error)
            ->tag($new->errorTag)
            ->render();
    }

    private function renderHint(): string
    {
        $new = clone $this;
        $hint = Hint::widget()->attributes($new->hintAttributes)->encode($new->encode)->tag($new->hintTag);

        if (
            $new->ariaDescribedBy === true
            && array_key_exists('id', $new->hintAttributes)
            && $new->widget instanceof AbstractWidget
        ) {
            $hint = $hint->id($new->widget->getInputId());
        }

        if ($new->hint === '' && $new->widget instanceof AbstractWidget) {
            $new->hint = $new->widget->getAttributeHint();
        }

        return $hint->hint($new->hint === '' ? null : $new->hint)->render();
    }

    private function renderLabel(): string
    {
        $new = clone $this;

        $label = Label::widget()->attributes($new->labelAttributes)->encode($new->encode);

        if ($new->label === '' && $new->widget instanceof AbstractWidget) {
            $new->label = $new->getAttributeLabel($new->widget->getFormModel(), $new->widget->getAttribute());
        }

        if (!array_key_exists('for', $new->labelAttributes) && $new->widget instanceof AbstractWidget) {
            /** @var string */
            $for = ArrayHelper::getValue($new->widgetAttributes, 'id', $new->widget->getInputId());
            $label = $label->forId($for);
        }

        return $label->label($new->label)->render();
    }

    private function setGlobalAttributes(): self
    {
        $new = clone $this;

        // set global attributes to widget.
        if ($new->widgetAttributes !== []) {
            $attributes = array_merge($new->widget->getAttributes(), $new->widgetAttributes);
            $new->widget = $new->widget->attributes($attributes);
        }

        return $new;
    }
}
