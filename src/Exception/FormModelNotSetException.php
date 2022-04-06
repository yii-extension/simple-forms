<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Exception;

use InvalidArgumentException;
use Yiisoft\FriendlyException\FriendlyExceptionInterface;

final class FormModelNotSetException extends InvalidArgumentException implements FriendlyExceptionInterface
{
    public function __construct()
    {
        parent::__construct($this->getName());
    }

    public function getName(): string
    {
        return 'Failed to create widget because form model is not set.';
    }

    public function getSolution(): ?string
    {
        return <<<SOLUTION
            You can configure the `FormModel::class` in two ways. The first way is through the widgets using the `for()`
        method `Text::create()->for(FormModel::class, attribute)`, where the first argument is the `FormModel::class`.
        The second way is through the `Field::class` where in each field type the first argument is the
        `FormModel::class`, `Field::widget->text(FormModel::class, attribute)`.
        SOLUTION;
    }
}
