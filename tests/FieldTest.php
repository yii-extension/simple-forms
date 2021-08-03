<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Validator\Formatter;
use Yiisoft\Validator\Validator;

final class FieldTest extends TestCase
{
    use TestTrait;

    private PersonalForm $personalForm;

    protected function setUp(): void
    {
        $this->model = new PersonalForm();
    }

    protected function tearDowm(): void
    {
        unset($this->model);
    }

    public function testDropdownList(): void
    {
        $cities = [
            '1' => [
                '2' => 'Moscu',
                '3' => 'San Petersburgo',
                '4' => 'Novosibirsk',
                '5' => 'Ekaterinburgo',
            ],
            '2' => [
                '6' => 'Santiago',
                '7' => 'Concepcion',
                '8' => 'Chillan',
            ],
        ];

        $groups = [
            '1' => ['class' => 'text-danger', 'label' => 'Russia'],
            '2' => ['class' => 'text-primary', 'label' => 'Chile'],
        ];

        $prompt = [
            'text' => 'Select City Birth',
            'attributes' => [
                'value' => '0',
                'selected' => 'selected',
            ],
        ];

        $this->model->setAttribute('cityBirth', 0);

        $html = Field::widget()
            ->config($this->model, 'cityBirth')
            ->containerClass('mb-3')
            ->inputClass('form-control')
            ->dropDownList($cities, [], $groups, $prompt)
            ->labelClass('form-label')
            ->template('{label}{input}{hint}')
            ->render();
        $expected = <<<'HTML'
        <div class="mb-3">
        <label class="form-label" for="personalform-citybirth">City Birth</label>
        <select id="personalform-citybirth" class="form-control" name="PersonalForm[cityBirth]">
        <option value="0" selected>Select City Birth</option>
        <optgroup class="text-danger" label="Russia">
        <option value="2">Moscu</option>
        <option value="3">San Petersburgo</option>
        <option value="4">Novosibirsk</option>
        <option value="5">Ekaterinburgo</option>
        </optgroup>
        <optgroup class="text-primary" label="Chile">
        <option value="6">Santiago</option>
        <option value="7">Concepcion</option>
        <option value="8">Chillan</option>
        </optgroup>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testInputWithValidation(): void
    {
        /** Add class is-invalid */
        $validator = $this->getValidator();
        $this->model->setAttribute('name', '');
        $validator->validate($this->model);

        $html = Field::widget()
            ->ariaDescribedBy()
            ->config($this->model, 'name')
            ->errorClass('invalid-feedback')
            ->invalidClass('is-invalid')
            ->template('{label}{input}{hint}{error}')
            ->validClass('is-valid')
            ->render();
        $expected = <<<'HTML'
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="is-invalid" name="PersonalForm[name]" value="" aria-describedby="personalform-name-hint" placeholder="Name" required>
        <div id="personalform-name-hint">Write your first name.</div>
        <div class="invalid-feedback">Value cannot be blank.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testNoLabel(): void
    {
        $html = Field::widget()
            ->config($this->model, 'name')
            ->noLabel()
            ->template('{label}{input}{hint}')
            ->render();
        $expected = <<<'HTML'
        <div>
        <input type="text" id="personalform-name" class="" name="PersonalForm[name]" value="" placeholder="Name" required>
        <div id="personalform-name-hint">Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testPasswordInput(): void
    {
        $html = Field::widget()
            ->ariaDescribedBy()
            ->config($this->model, 'password')
            ->passwordInput()
            ->template('{label}{input}{hint}')
            ->render();
        $expected = <<<'HTML'
        <div>
        <label for="personalform-password">Password</label>
        <input type="password" id="personalform-password" class="" name="PersonalForm[password]" value="" aria-describedby="personalform-password-hint" placeholder="Password">
        <div id="personalform-password-hint">Write your password.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldRadio(): void
    {
        $html = Field::widget()->config($this->model, 'terms')->radio()->template('{label}{input}')->render();

        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="0"> Terms</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderBootstrap5(): void
    {
        $html = $this->fieldBoostrapDefaultConfig();

        $expected = <<<HTML
        <div class="mb-3">
        <label class="form-label" for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" value="" aria-describedby="personalform-name-hint" placeholder="Name" required>
        <div id="personalform-name-hint" class="form-text">Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderBootstrap5WithValidation(): void
    {
        $expected = <<<HTML
        <div class="mb-3">
        <label class="form-label" for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" value="" aria-describedby="personalform-name-hint" placeholder="Name" required>
        <div id="personalform-name-hint" class="form-text">Write your first name.</div>
        <div class="invalid-feedback">Fill in this field.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $this->fieldBoostrapValidationConfig());
    }

    public function testRenderBulma(): void
    {
        $expected = <<<HTML
        <div class="field">
        <label class="label" for="personalform-name">Name</label>
        <div class="control">
        <input type="text" id="personalform-name" class="input" name="PersonalForm[name]" value="" placeholder="Name" required>
        </div>
        <div id="personalform-name-hint" class="help">Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $this->fieldBulmaDefaultConfig());
    }

    public function testRenderTailwind(): void
    {
        $expected = <<<HTML
        <div class="grid grid-cols-1 gap-6">
        <div class="block">
        <label class="text-gray-700" for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="mt-1 block w-full" name="PersonalForm[name]" value="" placeholder="Name" required>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $this->fieldTailwindDefaultConfig());
    }

    public function testTextArea(): void
    {
        $this->model->setAttribute('name', 'samdark');

        $html = Field::widget()
            ->config($this->model, 'name')
            ->containerClass('mb-3')
            ->labelClass('form-label')
            ->template('{label}{input}{hint}')
            ->textArea()
            ->render();
        $expected = <<<'HTML'
        <div class="mb-3">
        <label class="form-label" for="personalform-name">Name</label>
        <textarea id="personalform-name" name="PersonalForm[name]" placeholder="Name">samdark</textarea><div id="personalform-name-hint">Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testValidationIsInvalid(): void
    {
        /** Add class is-invalid */
        $validator = $this->getValidator();
        $this->model->setAttribute('name', '');
        $validator->validate($this->model);

        $html = Field::widget()
            ->ariaDescribedBy()
            ->config($this->model, 'name')
            ->inValidClass('is-invalid')
            ->template('{label}{input}{hint}{error}')
            ->validClass('is-valid')
            ->render();
        $expected = <<<'HTML'
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="is-invalid" name="PersonalForm[name]" value="" aria-describedby="personalform-name-hint" placeholder="Name" required>
        <div id="personalform-name-hint">Write your first name.</div>
        <div>Value cannot be blank.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testValidationIsValid(): void
    {
        /** Add class is-invalid */
        $validator = $this->getValidator();
        $this->model->setAttribute('name', 'samdark');
        $validator->validate($this->model);

        $html = Field::widget()
            ->ariaDescribedBy()
            ->config($this->model, 'name')
            ->inValidClass('is-invalid')
            ->template('{label}{input}{hint}{error}')
            ->validClass('is-valid')
            ->render();
        $expected = <<<'HTML'
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="is-valid" name="PersonalForm[name]" value="samdark" aria-describedby="personalform-name-hint" placeholder="Name" required>
        <div id="personalform-name-hint">Write your first name.</div>
        <div></div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    private function fieldBoostrapDefaultConfig(): string
    {
        return Field::widget()
            ->config($this->model, 'name')
            ->ariaDescribedBy(true)
            ->containerClass('mb-3')
            ->hintClass('form-text')
            ->inputClass('form-control')
            ->labelClass('form-label')
            ->template('{label}{input}{hint}')
            ->render();
    }

    private function fieldBoostrapValidationConfig(): string
    {
        return Field::widget()
            ->config($this->model, 'name')
            ->ariaDescribedBy(true)
            ->containerClass('mb-3')
            ->errorClass('invalid-feedback')
            ->errorMessage('Fill in this field.')
            ->hintClass('form-text')
            ->inputClass('form-control')
            ->labelClass('form-label')
            ->required()
            ->template('{label}{input}{hint}{error}')
            ->render();
    }

    private function fieldBulmaDefaultConfig(): string
    {
        return Field::widget()
            ->config($this->model, 'name')
            ->containerClass('field')
            ->hintClass('help')
            ->inputClass('input')
            ->labelClass('label')
            ->template("{label}<div class=\"control\">\n{input}</div>\n{hint}")
            ->render();
    }

    private function fieldTailwindDefaultConfig(): string
    {
        return Field::widget()
            ->config($this->model, 'name')
            ->containerClass('grid grid-cols-1 gap-6')
            ->inputClass('mt-1 block w-full')
            ->labelClass('text-gray-700')
            ->noHint()
            ->template("<div class=\"block\">\n{label}{input}</div>\n")
            ->render();
    }

    private function getValidator(): Validator
    {
        return new Validator(new Formatter());
    }
}
