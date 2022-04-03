<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Attribute;

use Yii\Extension\Form\Exception\AttributeNotSetException;
use Yii\Extension\Form\Exception\FormModelNotSetException;
use Yii\Extension\FormModel\Contract\FormModelContract;

abstract class WidgetAttributes extends GlobalAttributes
{
    private string $attribute = '';
    private ?FormModelContract $formModel = null;

    public function for(FormModelContract $formModel, string $attribute): static
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = match ($new->getFormModel()->has($attribute)) {
            true => $attribute,
            false => throw new AttributeNotSetException($attribute),
        };
        return $new;
    }

    protected function getAttribute(): string
    {
        return $this->attribute;
    }

    /**
     * Return FormModelContract object.
     *
     * @return FormModelContract
     */
    protected function getFormModel(): FormModelContract
    {
        return match (empty($this->formModel)) {
            true => throw new FormModelNotSetException(),
            false => $this->formModel,
        };
    }
}
