<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\TestSupport\Form;

use Yii\Extension\Simple\Model\BaseModel;

final class FormWithNestedAttribute extends BaseModel
{
    private ?int $id = null;
    private ?LoginForm $user = null;

    public function __construct()
    {
        $this->user = new LoginForm();
        parent::__construct();
    }

    public function getAttributeLabels(): array
    {
        return [
            'id' => 'ID',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'id' => 'Readonly ID',
        ];
    }

    public function getAttributePlaceholders(): array
    {
        return [
            'id' => 'Type ID.',
        ];
    }

    public function getRules(): array
    {
        return [
            'id' => new Required(),
        ];
    }

    public function setUserLogin(string $login): void
    {
        $this->user->login('admin');
    }

    public function getUserLogin(): ?string
    {
        return $this->user->getLogin();
    }
}
