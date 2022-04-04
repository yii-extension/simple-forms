<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\TestSupport\Form;

use Yii\Extension\Model\FormModel;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Regex;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Url;

final class ValidatorRules extends FormModel
{
    private string $maxlength = '';
    private string $minlength = '';
    private int $number = 0;
    private int $numberRequired = 0;
    private string $regex = '';
    private string $required = '';
    private string $url = '';
    private string $urlWithPattern = '';

    public function getRules(): array
    {
        return [
            'maxlength' => [new HasLength(max: 50)],
            'minlength' => [new HasLength(min: 15)],
            'number' => [new Number(min: 3, max: 5)],
            'numberRequired' => [new Required()],
            'regex' => [new Regex('/\w+/')],
            'required' => [new Required()],
            'url' => [new Url()],
            'urlWithPattern' => [new Url(validSchemes: ['Http', 'Https'])],
        ];
    }
}
