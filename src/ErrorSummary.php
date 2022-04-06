<?php

declare(strict_types=1);

namespace Yii\Extension\Form;

use InvalidArgumentException;
use Yii\Extension\Form\Exception\FormModelNotSetException;
use Yii\Extension\Model\Contract\FormModelContract;
use Yii\Extension\Widget\SimpleWidget;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\P;
use Yiisoft\Html\Tag\Ul;

use function array_flip;
use function array_intersect_key;
use function array_unique;
use function array_values;

/**
 * The error summary widget displays a summary of the errors in a form.
 */
final class ErrorSummary extends SimpleWidget
{
    private bool $encode = true;
    private array $onlyAttributes = [];
    private ?FormModelContract $formModel = null;
    private string $footer = '';
    private array $footerAttributes = [];
    private string $header = 'Please fix the following errors:';
    private array $headerAttributes = [];
    private bool $showAllErrors = false;
    /** @psalm-param non-empty-string */
    private string $tag = 'div';

    /**
     * Whether content should be HTML-encoded.
     *
     * @param bool $value
     *
     * @return self
     */
    public function encode(bool $value): self
    {
        $new = clone $this;
        $new->encode = $value;
        return $new;
    }

    /**
     * Set the footer text for the error summary
     *
     * @param string $value
     *
     * @return self
     */
    public function footer(string $value): self
    {
        $new = clone $this;
        $new->footer = $value;
        return $new;
    }

    /**
     * Set footer attributes for the error summary.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function footerAttributes(array $values): self
    {
        $new = clone $this;
        $new->footerAttributes = $values;
        return $new;
    }

    /**
     * Set the header text for the error summary
     *
     * @param string $value
     *
     * @return self
     */
    public function header(string $value): self
    {
        $new = clone $this;
        $new->header = $value;
        return $new;
    }

    /**
     * Set header attributes for the error summary.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function headerAttributes(array $values): self
    {
        $new = clone $this;
        $new->headerAttributes = $values;
        return $new;
    }

    /**
     * Set the model for the error summary.
     *
     * @param FormModelContract $formModel
     *
     * @return self
     */
    public function model(FormModelContract $formModel): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
        return $new;
    }

    /**
     * Whether to show all errors.
     *
     * @param bool $value
     *
     * @return self
     */
    public function showAllErrors(bool $value): self
    {
        $new = clone $this;
        $new->showAllErrors = $value;
        return $new;
    }

    /**
     * Specific attributes to be filtered out when rendering the error summary.
     *
     * @param array $values The attributes to be included in error summary.
     *
     * @return self
     */
    public function onlyAttributes(string ...$values): self
    {
        $new = clone $this;
        $new->onlyAttributes = $values;
        return $new;
    }

    /**
     * Set the container tag name for the error summary.
     *
     * Empty to render error messages without container {@see Html::tag()}.
     *
     * @param string $value
     *
     * @return self
     */
    public function tag(string $value): self
    {
        $new = clone $this;
        $new->tag = $value;
        return $new;
    }

    /**
     * Return array of the validation errors.
     *
     * @return array of the validation errors.
     */
    private function collectErrors(): array
    {
        $formErrors = $this->getFormModel()->error();
        $errors = $formErrors->getSummaryFirst();
        $errorMessages = [];

        if ($this->showAllErrors) {
            $errors = $formErrors->getSummary($this->onlyAttributes);
        } elseif ($this->onlyAttributes !== []) {
            $errors = array_intersect_key($errors, array_flip($this->onlyAttributes));
        }

        /**
         * If there are the same error messages for different attributes, array_unique will leave gaps between
         * sequential keys. Applying array_values to reorder array keys.
         */
        $lines = array_values(array_unique($errors));

        if ($this->encode) {
            /** @var string $line */
            foreach ($lines as $line) {
                if (!empty($line)) {
                    $errorMessages[] = Html::encode($line);
                }
            }
        }

        return $errorMessages;
    }

    /**
     * Generates a summary of the validation errors.
     *
     * @return string the generated error summary
     */
    protected function run(): string
    {
        $attributes = $this->attributes;
        $content = '';

        if ($this->tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        $content .=  P::tag()->attributes($this->headerAttributes)->content($this->header)->render() . PHP_EOL;

        /** @var array<string, string> */
        $lines = $this->collectErrors();
        $content .= Ul::tag()->strings($lines)->render();

        if ($this->footer !== '') {
            $content .= PHP_EOL . P::tag()->attributes($this->footerAttributes)->content($this->footer)->render();
        }

        return match (empty($lines)) {
            true => '',
            false => CustomTag::name($this->tag)
                ->attributes($attributes)
                ->encode(false)
                ->content(PHP_EOL . $content . PHP_EOL)
                ->render(),
        };
    }

    /**
     * Return FormModelContract object.
     *
     * @return FormModelContract
     */
    private function getFormModel(): FormModelContract
    {
        return match (empty($this->formModel)) {
            true => throw new FormModelNotSetException(),
            false => $this->formModel,
        };
    }
}
