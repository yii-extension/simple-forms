<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yii\Extension\Simple\Model\Helper\HtmlForm;
use Yii\Extension\Simple\Model\Helper\HtmlFormErrors;
use Yiisoft\Widget\Widget;

abstract class AbstractForm extends Widget
{
    protected array $attributes = [];
    private bool $ariaDescribedBy = false;
    private ?string $buttonsClass = null;
    private ?string $containerClass = null;
    protected bool $encode = false;
    private bool $withoutButtonsContainer = false;
    private bool $withoutContainer = false;

    /**
     * The accept-charset content attribute gives the character encodings that are to be used for the submission.
     * If specified, the value must be an ordered set of unique space-separated tokens that are ASCII case-insensitive,
     * and each token must be an ASCII case-insensitive match for one of the labels of an ASCII-compatible encoding.
     *
     * @param string $value the accept-charset attribute value.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-accept-charset
     */
    public function acceptCharset(string $value): self
    {
        $new = clone $this;
        $new->attributes['accept-charset'] = $value;
        return $new;
    }

    public function ariaDescribedBy(bool $ariaDescribedBy): self
    {
        $new = clone $this;
        $new->ariaDescribedBy = $ariaDescribedBy;
        return $new;
    }

    /**
     * Specifies whether the element represents an input control for which a UA is meant to store the value entered by
     * the user (so that the UA can prefill the form later).
     *
     * @param bool $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-autocompleteelements-autocomplete
     */
    public function autocomplete(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['autocomplete'] = $value ? 'on' : 'off';
        return $new;
    }

    /**
     * The HTML attributes. The following special options are recognized.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = $values;
        return $new;
    }

    public function buttonsClass(string $value): self
    {
        $new = clone $this;
        $new->buttonsClass = $value;
        return $new;
    }

    public function containerClass(string $value): self
    {
        $new = clone $this;
        $new->containerClass = $value;
        return $new;
    }

    /**
     * Whether content should be HTML-encoded.
     *
     * @param bool $value
     *
     * @return static
     */
    public function encode(bool $value): self
    {
        $new = clone $this;
        $new->encode = $value;
        return $new;
    }

    /**
     * The formenctype content attribute specifies the content type of the form submission.
     *
     * @param string $value the formenctype attribute value.
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fs-enctype
     */
    public function enctype(string $value): self
    {
        $new = clone $this;
        $new->attributes['enctype'] = $value;
        return $new;
    }

    /**
     * The id content attribute is a unique identifier for the element.
     *
     * @param string $value the id attribute value.
     *
     * @return static
     */
    public function id(string $value): self
    {
        $new = clone $this;
        $new->attributes['id'] = $value;
        return $new;
    }

    /**
     * The novalidate and formnovalidate content attributes are boolean attributes. If present, they indicate that the
     * form is not to be validated during submission.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-novalidate
     */
    public function noHtmlValidation(): self
    {
        $new = clone $this;
        $new->attributes['novalidate'] = true;
        return $new;
    }

    /**
     * The target and formtarget content attributes, if specified, must have values that are valid browsing context
     * names or keywords.
     *
     * @param string $value the target attribute value, for default its `_blank`.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-target
     */
    public function target(string $value): self
    {
        $new = clone $this;
        $new->attributes['target'] = $value;
        return $new;
    }

    public function withoutButtonsContainer(): self
    {
        $new = clone $this;
        $new->withoutButtonsContainer = true;
        return $new;
    }

    public function withoutContainer(): self
    {
        $new = clone $this;
        $new->withoutContainer = true;
        return $new;
    }

    protected function getAriaDescribedBy(): bool
    {
        return $this->ariaDescribedBy;
    }

    protected function getAttributeHint(AbstractWidget $widget): string
    {
        return HtmlForm::getAttributeHint($widget->getFormModel(), $widget->getAttribute());
    }

    protected function getAttributeLabel(AbstractWidget $widget): string
    {
        return HtmlForm::getAttributeLabel($widget->getFormModel(), $widget->getAttribute());
    }

    protected function getButtonsClass(): ?string
    {
        return $this->buttonsClass;
    }

    protected function getContainerClass(): ?string
    {
        return $this->containerClass;
    }

    protected function getEncode(): bool
    {
        return $this->encode;
    }

    protected function getFirstError(AbstractWidget $widget): string
    {
        return HtmlFormErrors::getFirstError($widget->getFormModel(), $widget->getAttribute());
    }

    protected function getWithoutButtonsContainer(): bool
    {
        return $this->withoutButtonsContainer;
    }

    protected function getWithoutContainer(): bool
    {
        return $this->withoutContainer;
    }
}
