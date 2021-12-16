<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Stringable;
use Yii\Extension\Simple\Forms\Attribute\FieldAttributes;
use Yii\Extension\Simple\Forms\Attribute\GlobalAttributes;
use Yii\Extension\Simple\Forms\Interface\HasLengthInterface;
use Yii\Extension\Simple\Forms\Interface\MatchRegularInterface;
use Yii\Extension\Simple\Forms\Interface\NumberInterface;
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
     *
     * @return static the field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotInstantiableException|NotFoundException
     */
    public function password(FormModelInterface $formModel, string $attribute): self
    {
        $new = clone $this;
        $new->widget = Password::widget()->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a reset button widget.
     *
     * @return static the field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function resetButton(): self
    {
        $new = clone $this;
        $new->buttons[] = ResetButton::widget();
        return $new;
    }

    /**
     * Renders a submit button widget.
     *
     * @return static the field object itself.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function submitButton(): self
    {
        $new = clone $this;
        $new->buttons[] = SubmitButton::widget();
        return $new;
    }

    /**
     * Renders a text widget.
     *
     * @param FormModelInterface $formModel the model object.
     * @param string $attribute the attribute name or expression.
     *
     * @return static the field widget instance.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function text(FormModelInterface $formModel, string $attribute): self
    {
        $new = clone $this;
        $new->widget = Text::widget()->for($formModel, $attribute);
        return $new;
    }

    /**
     * Set the template for the field.
     *
     * @param string $value the template.
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
     * @param FormModelInterface $formModel the model object.
     * @param string $attribute the attribute name or expression.
     *
     * @return static the field widget instance.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function url(FormModelInterface $formModel, string $attribute): self
    {
        $new = clone $this;
        $new->widget = Url::widget()->for($formModel, $attribute);
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
        /** @psalm-var array<array-key, Rule> */
        $rules = $new->widget->getFormModel()->getRules()[$new->widget->getAttribute()] ?? [];

        foreach ($rules as $rule) {
            if ($rule instanceof Required) {
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
