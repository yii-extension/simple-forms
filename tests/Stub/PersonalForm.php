<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Stub;

use Yii\Extension\Simple\Forms\FormModelInterface;
use Yii\Extension\Simple\Model\AbstractModel;

final class PersonalForm extends AbstractModel implements FormModelInterface
{
    private string $id = '';
    private string $name = '';

    public function getAttributeLabels(): array
    {
        return [];
    }

    public function getAttributeHints(): array
    {
        return [
            'name' => 'Write your first name.',
        ];
    }
}
