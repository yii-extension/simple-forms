<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Factory\Exception\InvalidConfigException;
use Yiisoft\Html\Html;

use function array_merge;
use function strtr;

/**
 * Renders the field widget along with label and hint tag (if any) according to template.
 */
final class Field extends Widget
{
    private bool $ariaDescribedBy = false;
    private string $containerCssClass = '';
    private string $hintCssClass = '';
    private string $inputCssClass = '';
    private string $labelCssClass = '';
    private string $template = '';
    private array $parts = [];
    private bool $noLabel = false;
    private bool $noHint = false;

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

        if (!isset($new->parts['{label}'])) {
            $new = $new->label();
        }

        if (!isset($new->parts['{hint}'])) {
            $new = $new->hint();
        }

        if (!isset($new->parts['{input}'])) {
            $new = $new->textInput();
        }

        $html = strtr($new->template, $new->parts);

        return $new->renderBegin() . "\n" . $html . $new->renderEnd();
    }

    public function ariaDescribedBy(): self
    {
        $new = clone $this;
        $new->ariaDescribedBy = true;
        return $new;
    }

    public function bootstrap(): self
    {
        $new = clone $this;
        $new->ariaDescribedBy = true;
        $new->containerCssClass = 'mb-3';
        $new->hintCssClass = 'form-text';
        $new->inputCssClass = 'form-control';
        $new->labelCssClass = 'form-label';
        $new->template = '{label}{input}{hint}';
        return $new;
    }

    public function bulma(): self
    {
        $new = clone $this;
        $new->containerCssClass = 'field';
        $new->hintCssClass = 'help';
        $new->inputCssClass = 'input';
        $new->labelCssClass = 'label';
        $new->template = "{label}<div class=\"control\">\n{input}</div>\n{hint}";
        return $new;
    }

    public function containerCssClass(string $value): self
    {
        $new = clone $this;
        $new->containerCssClass = $value;
        return $new;
    }

    /**
     * Renders the hint tag.
     *
     * @param string $content the hint content.
     * If ``, the hint will be generated via {@see \Yii\Extension\Simple\Model\ModelInterface::getAttributeHint()}.
     * @param array $attributes the tag attributes in terms of name-value pairs. These will be rendered as the
     * attributes of the hint tag. The values will be HTML-encoded using {@see Html::encode()}.
     */
    public function hint(string $content = '', array $attributes = []): self
    {
        $new = clone $this;
        $new->parts['{hint}'] = '';

        if ($new->noHint === false) {
            Html::addCssClass($attributes, ['hintCssClass' => $new->hintCssClass]);

            $new->parts['{hint}'] = Hint::widget()
                ->config($new->modelInterface, $new->attribute, $attributes)
                ->hint($content) . "\n";
        }

        return $new;
    }

    public function hintCssClass(string $value): self
    {
        $new = clone $this;
        $new->hintCssClass = $value;
        return $new;
    }

    public function inputCssClass(string $value): self
    {
        $new = clone $this;
        $new->inputCssClass = $value;
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
     */
    public function label(string $label = '', array $attributes = []): self
    {
        $new = clone $this;
        $new->parts['{label}'] = '';

        if ($new->noLabel === false) {
            Html::addCssClass($attributes, ['labelCssClass' => $new->labelCssClass]);

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

    public function tailwind(): self
    {
        $new = clone $this;
        $new->containerCssClass = 'grid grid-cols-1 gap-6';
        $new->inputCssClass = 'mt-1 block w-full';
        $new->labelCssClass = 'text-gray-700';
        $new->noHint = true;
        $new->template = "<div class=\"block\">\n{label}{input}</div>\n";
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
     */
    public function textInput(array $attributes = []): self
    {
        $new = clone $this;

        Html::addCssClass($attributes, ['inputCssClass' => $new->inputCssClass]);

        if ($new->ariaDescribedBy === true) {
            $attributes['aria-describedby'] = $new->getId(
                $new->modelInterface->getFormName(),
                $new->attribute,
            ) . '-hint';
        }

        $new->parts['{input}'] = Input::widget()->config($new->modelInterface, $new->attribute, $attributes) . "\n";

        return $new;
    }

    public function template(string $value): self
    {
        $new = clone $this;
        $new->template = $value;
        return $new;
    }

    /**
     * Renders the opening tag of the field container.
     */
    private function renderBegin(): string
    {
        $new = clone $this;

        Html::addCssClass($new->attributes, ['containerCssClass' => $new->containerCssClass]);

        return Html::openTag('div', $new->attributes);
    }

    /**
     * Renders the closing tag of the field container.
     */
    private function renderEnd(): string
    {
        return Html::closeTag('div');
    }
}
