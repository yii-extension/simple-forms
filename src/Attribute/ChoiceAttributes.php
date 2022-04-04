<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Attribute;

use Yii\Extension\Form\Validator\FieldValidator;
use Yii\Extension\FormModel\Attribute\FormModelAttributes;

abstract class ChoiceAttributes extends WidgetAttributes
{
    /**
     * If it is required to fill in a value in order to submit the form.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-required-attribute
     */
    public function required(): static
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

        return (new FieldValidator())->getValidatorAttributes(
            $this,
            $this->getFormModel(),
            $this->getAttribute(),
            $attributes,
        );
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
            $containerAttributes['id'] = FormModelAttributes::getInputId($this->getFormModel(), $this->getAttribute());
        }

        if (array_key_exists('tabindex', $attributes)) {
            /** @var string */
            $containerAttributes['tabindex'] = $attributes['tabindex'];
            unset($attributes['tabindex']);
        }

        return [$attributes, $containerAttributes];
    }
}
