<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\TestSupport\Form;

use Yii\Extension\Simple\Model\FormModel;

final class TypeForm extends FormModel
{
    private ?array $array = [];
    private ?bool $bool = null;
    private ?int $int = null;
    private ?object $object = null;
    private ?string $string = '';
}
