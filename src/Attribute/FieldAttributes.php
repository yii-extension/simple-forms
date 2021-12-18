<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Attribute;

use Yii\Extension\Simple\Model\FormModelInterface;
use Yii\Extension\Simple\Model\Helper\HtmlForm;
use Yiisoft\Html\Html;

abstract class FieldAttributes extends GlobalAttributes
{
    protected bool $ariaDescribedBy = false;
    protected string $ariaLabel = '';
    protected array $buttonsIndividualAttributes = [];
    protected bool $container = false;
    protected array $containerAttributes = [];
    protected string $containerClass = '';
    protected string $error = '';
    protected array $errorAttributes = [];
    protected string $errorTag = 'div';
    protected string|null $hint = '';
    protected array $hintAttributes = [];
    protected string $hintTag = 'div';
    protected string $inputClass = '';
    protected string $invalidClass = '';
    protected string|null $label = '';
    protected array $labelAttributes = [];
    protected string|null $placeHolder = null;
    protected string $validClass = '';

    /**
     * Set aria-label attribute.
     *
     * @return static
     */
    public function ariaLabel(string $value): self
    {
        $new = clone $this;
        $new->ariaLabel = $value;
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

    /**
     * Set individual attributes for the buttons widgets.
     *
     * @return static
     */
    public function buttonsIndividualAttributes(array $value): self
    {
        $new = clone $this;
        $new->buttonsIndividualAttributes = $value;
        return $new;
    }

    /**
     * Set container attributes.
     *
     * @return static
     */
    public function containerAttributes(array $value): self
    {
        $new = clone $this;
        $new->containerAttributes = $value;
        return $new;
    }

    /**
     * Set container ID.
     *
     * @return static
     */
    public function containerId(string $value): self
    {
        $new = clone $this;
        $new->containerAttributes['id'] = $value;
        return $new;
    }

    /**
     * Set container name.
     *
     * @return static
     */
    public function containerName(string $value): self
    {
        $new = clone $this;
        $new->containerAttributes['name'] = $value;
        return $new;
    }

    /**
     * Set CSS class for the container field.
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
     * @return static
     */
    public function error(string $value): self
    {
        $new = clone $this;
        $new->error = $value;
        return $new;
    }

    /**
     * @return static
     */
    public function errorAttributes(array $value): self
    {
        $new = clone $this;
        $new->errorAttributes = $value;
        return $new;
    }

    /**
     * @return static
     */
    public function errorClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->errorAttributes, $value);
        return $new;
    }

    /**
     * @return static
     */
    public function errorTag(string $value): self
    {
        $new = clone $this;
        $new->errorTag = $value;
        return $new;
    }

    /**
     * @return static
     */
    public function hint(string $value): self
    {
        $new = clone $this;
        $new->hint = $value;
        return $new;
    }

    /**
     * The HTML attributes for hint widget. The following special options are recognized.
     *
     * @param array $value Attribute values indexed by attribute names.
     *
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function hintAttributes(array $value): self
    {
        $new = clone $this;
        $new->hintAttributes = $value;
        return $new;
    }

    /**
     * Set CSS class names to the hint widget.
     *
     * @param string $value CSS class names.
     *
     * @return static
     */
    public function hintClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->hintAttributes, $value);
        return $new;
    }

    /**
     * Set the tag name of the hint widget.
     *
     * @param string $value The tag name.
     *
     * @return static
     */
    public function hintTag(string $value): self
    {
        $new = clone $this;
        $new->hintTag = $value;
        return $new;
    }

    /**
     * Set CSS class names to widget for field.
     *
     * @param string $value CSS class names.
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
     * Set CSS class names to widget for invalid field.
     *
     * @param string $value CSS class names.
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
     * Set the label of the field.
     *
     * @param string $value The label.
     *
     * @return static
     */
    public function label(string $value): self
    {
        $new = clone $this;
        $new->label = $value;
        return $new;
    }

    /**
     * The HTML attributes for label widget. The following special options are recognized.
     *
     * @param array $value Attribute values indexed by attribute names.
     *
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function labelAttributes(array $value): self
    {
        $new = clone $this;
        $new->labelAttributes = $value;
        return $new;
    }

    /**
     * Set CSS class names to the label widget.
     *
     * @param string $value CSS class names.
     *
     * @return static
     */
    public function labelClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->labelAttributes, $value);
        return $new;
    }

    /**
     * Set attributes for id the label widget.
     *
     * @param string $value
     *
     * @return static
     */
    public function labelFor(string $value): self
    {
        $new = clone $this;
        $new->labelAttributes['for'] = $value;
        return $new;
    }

    /**
     * Set placeholder attribute for the field.
     *
     * @param string|null $value The placeholder.
     *
     * @return static
     */
    public function placeHolder(?string $value): self
    {
        $new = clone $this;
        $new->placeHolder = $value;
        return $new;
    }

    /**
     * Set CSS class names to widget for valid field.
     *
     * @param string $value CSS class names.
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
     * Disabled container for field.
     *
     * @return static
     */
    public function withoutContainer(): self
    {
        $new = clone $this;
        $new->container = true;
        return $new;
    }

    /**
     * @return static
     */
    public function withoutHint(): self
    {
        $new = clone $this;
        $new->hint = null;
        return $new;
    }

    /**
     * @return static
     */
    public function withoutLabel(): self
    {
        $new = clone $this;
        $new->label = null;
        return $new;
    }

    /**
     * @return static
     */
    public function withoutLabelFor(): self
    {
        $new = clone $this;
        $new->labelAttributes['for'] = null;
        return $new;
    }

    public function getAttributeLabel(FormModelInterface $formModel, string $attribute): string
    {
        return HtmlForm::getAttributeLabel($formModel, $attribute);
    }
}
