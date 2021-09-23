<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Validator\ValidatorMock;

final class FieldErrorTest extends TestCase
{
    use TestTrait;

    private PersonalForm $model;

    public function testTabularErrors(): void
    {
        $validator = $this->createValidatorMock();
        $this->model->setAttribute('name', 'sam');
        $validator->validate($this->model);

        $expected = <<<'HTML'
        <div>
        <label for="personalform-0-name">Name</label>
        <input type="text" id="personalform-0-name" name="PersonalForm[0][name]" value="sam">
        <div>Write your first name.</div>
        <div>Is too short.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->config($this->model, '[0]name')->render());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new PersonalForm();
    }
}
