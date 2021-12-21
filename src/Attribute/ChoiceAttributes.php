<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Attribute;

use Yii\Extension\Simple\Forms\Validator\FieldValidator;
use Yii\Extension\Simple\Forms\Widget;
use Yii\Extension\Simple\Model\FormModelInterface;
use Yii\Extension\Simple\Model\Helper\HtmlForm;
use Yiisoft\Html\Html;

abstract class ChoiceAttributes extends Widget
{
    /**
     * Set whether the element is disabled or not.
     *
     * If this attribute is set to `true`, the element is disabled. Disabled elements are usually drawn with grayed-out
     * text.
     * If the element is disabled, it does not respond to user actions, it cannot be focused, and the command event
     * will not fire. In the case of form elements, it will not be submitted. Do not set the attribute to true, as
     * this will suggest you can set it to `false` to enable the element again, which is not the case.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-disabledformelements-disabled
     */
    public function disabled(): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = true;
        return $new;
    }

    /**
     * If it is required to fill in a value in order to submit the form.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-required-attribute
     */
    public function required(): self
    {
        $new = clone $this;
        $new->attributes['required'] = true;
        return $new;
    }

    /**
     * Set build attributes for the ChoiceWidget.
     *
     * @param array $attributes $value
     *
     * @return array
     */
    protected function build(array $attributes): array
    {
        if (!array_key_exists('id', $attributes)) {
            $attributes['id'] = $this->getInputId();
        }

        if (!array_key_exists('name', $attributes)) {
            $attributes['name'] = $this->getInputName();
        }

        $fieldValidator = new FieldValidator();

        $attributes = $fieldValidator->getValidatorAttributes(
            $this,
            $this->getFormModel(),
            $this->getAttribute(),
            $attributes,
        );

        return $attributes;
    }

    /**
     * Set build container attributes for the ChoiceListWidget.
     *
     * @param array $attributes $value
     * @param array $containerAttributes
     *
     * @return array
     */
    protected function buildList(array $attributes, array $containerAttributes): array
    {
        if (array_key_exists('autofocus', $attributes)) {
            /** @var string */
            $containerAttributes['autofocus'] = $attributes['autofocus'];
            unset($attributes['autofocus']);
        }

        if (array_key_exists('id', $attributes)) {
            /** @var string */
            $containerAttributes['id'] = $attributes['id'];
            unset($attributes['id']);
        }

        if (!array_key_exists('id', $containerAttributes)) {
            $containerAttributes['id'] = $this->getInputId();
        }

        if (array_key_exists('tabindex', $attributes)) {
            /** @var string */
            $containerAttributes['tabindex'] = $attributes['tabindex'];
            unset($attributes['tabindex']);
        }

        return [$attributes, $containerAttributes];
    }
}
