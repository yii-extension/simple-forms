<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\TestSupport\Form;

use Yii\Extension\Simple\Model\FormModel;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\MatchRegularExpression;
use Yiisoft\Validator\Rule\Required;

final class ValidatorForm extends FormModel
{
    private string $matchregular = '';
    private string $maxlength = '';
    private string $minlength = '';
    private string $required = '';

    public function getRules(): array
    {
        return [
            'matchregular' => [MatchRegularExpression::rule('/\w+/')],
            'maxlength' => [HasLength::rule()->max(50)],
            'minlength' => [HasLength::rule()->min(15)],
            'required' => [Required::rule()],
        ];
    }
}
