<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Stub;

use Yii\Extension\Simple\Model\BaseModel;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Required;

final class PersonalForm extends BaseModel
{
    private string $id = '';
    private array $citys = [];
    private ?int $cityBirth = null;
    private string $name = '';
    private int $terms = 0;

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

    public function getRules(): array
    {
        return [
            'name' => [Required::rule(), HasLength::rule()->min(4)->tooShortMessage('Is too short.')],
        ];
    }

    public function validate(): bool
    {
        $this->clearErrors();

        $rules = $this->rules();

        if (!empty($rules)) {
            $results = (new Validator($rules))->validate($this);

            foreach ($results as $attribute => $result) {
                if ($result->isValid() === false) {
                    $this->addErrors([$attribute => $result->getErrors()]);
                }
            }
        }

        return !$this->hasErrors();
    }
}
