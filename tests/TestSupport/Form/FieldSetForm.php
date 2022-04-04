<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\TestSupport\Form;

use Yii\Extension\FormModel\FormModel;

final class FieldSetForm extends FormModel
{
    private string $description = '';
    private string $end = '';
    private string $name = '';
    private string $start = '';
    private string $state = '';
}
