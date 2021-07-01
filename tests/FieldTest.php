<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Validator\Formatter;
use Yiisoft\Validator\Validator;

final class FieldTest extends TestCase
{
    use TestTrait;

    private PersonalForm $personalForm;

    protected function setUp(): void
    {
        $this->personalForm = new PersonalForm();
    }

    protected function tearDowm(): void
    {
        unset($this->personalForm);
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

        $html = Field::widget()
            ->config($this->personalForm, 'cityBirth')
            ->containerCssClass('mb-3')
            ->dropDownList($cities, ['class' => 'form-control'], $groups, $prompt)
            ->labelCssClass('form-label')
            ->template('{label}{input}{hint}')
            ->render();
        $expected = <<<'HTML'
        <div class="mb-3">
        <label class="form-label" for="personalform-citybirth">City Birth</label>
        <select id="personalform-citybirth" class="form-control " name="PersonalForm[cityBirth]">
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

    public function testNoLabel(): void
    {
        $html = Field::widget()
            ->config($this->personalForm, 'name')
            ->noLabel()
            ->template('{label}{input}{hint}')
            ->render();
        $expected = <<<'HTML'
        <div class="">
        <input type="text" id="personalform-name" class="" name="PersonalForm[name]" value="" placeholder="Name" required>
        <div id="personalform-name-hint" class="">Write your first name.</div>
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
        $model = new PersonalForm();

        $html = $this->fieldBoostrapValidationConfig();

        $expected = <<<HTML
        <div class="mb-3">
        <label class="form-label" for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" value="" aria-describedby="personalform-name-hint" placeholder="Name" required>
        <div id="personalform-name-hint" class="form-text">Write your first name.</div>
        <div class="invalid-feedback">Fill in this field.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderBulma(): void
    {
        $html = $this->fieldBulmaDefaultConfig();

        $expected = <<<HTML
        <div class="field">
        <label class="label" for="personalform-name">Name</label>
        <div class="control">
        <input type="text" id="personalform-name" class="input" name="PersonalForm[name]" value="" placeholder="Name" required>
        </div>
        <div id="personalform-name-hint" class="help">Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderTailwind(): void
    {
        $html = $this->fieldTailwindDefaultConfig();

        $expected = <<<HTML
        <div class="grid grid-cols-1 gap-6">
        <div class="block">
        <label class="text-gray-700" for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="mt-1 block w-full" name="PersonalForm[name]" value="" placeholder="Name" required>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldsTextArea(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('name', 'samdark');

        $html = Field::widget()
            ->config($model, 'name')
            ->containerCssClass('mb-3')
            ->labelCssClass('form-label')
            ->template('{label}{input}{hint}')
            ->textArea()
            ->render();
        $expected = <<<'HTML'
        <div class="mb-3">
        <label class="form-label" for="personalform-name">Name</label>
        <textarea id="personalform-name" name="PersonalForm[name]" placeholder="Name">samdark</textarea><div id="personalform-name-hint" class="">Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testValidation(): void
    {
        $model = new PersonalForm();

        $html = Field::widget()->config($this->personalForm, 'name')->template('{label}{input}{hint}')->render();
        $expected = <<<'HTML'
        <div class="">
        <label class="" for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="" name="PersonalForm[name]" value="" placeholder="Name" required>
        <div id="personalform-name-hint" class="">Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        /** Add class is-invalid */
        $validator = $this->getValidator();
        $model->setAttribute('name', '');
        $validator->validate($model);

        $html = Field::widget()
            ->config($model, 'name')
            ->invalidCssClass('is-invalid')
            ->template('{label}{input}{hint}')
            ->render();
        $expected = <<<'HTML'
        <div class="">
        <label class="" for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="is-invalid" name="PersonalForm[name]" value="" placeholder="Name" required>
        <div id="personalform-name-hint" class="">Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        /** Add class is-valid */
        $validator = $this->getValidator();
        $model->setAttribute('name', 'samdark');
        $validator->validate($model);

        $html = Field::widget()->config($model, 'name')
            ->validCssClass('is-valid')
            ->template('{label}{input}{hint}')
            ->render();
        $expected = <<<'HTML'
        <div class="">
        <label class="" for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="is-valid" name="PersonalForm[name]" value="samdark" placeholder="Name" required>
        <div id="personalform-name-hint" class="">Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    private function fieldBoostrapDefaultConfig(): string
    {
        return Field::widget()
            ->config($this->personalForm, 'name')
            ->ariaDescribedBy(true)
            ->containerCssClass('mb-3')
            ->hintCssClass('form-text')
            ->inputCssClass('form-control')
            ->labelCssClass('form-label')
            ->template('{label}{input}{hint}')
            ->render();
    }

    private function fieldBoostrapValidationConfig(): string
    {
        return Field::widget()
            ->config($this->personalForm, 'name')
            ->ariaDescribedBy(true)
            ->containerCssClass('mb-3')
            ->errorCssClass('invalid-feedback')
            ->errorMessage('Fill in this field.')
            ->hintCssClass('form-text')
            ->inputCssClass('form-control')
            ->labelCssClass('form-label')
            ->required()
            ->template('{label}{input}{hint}{error}')
            ->render();
    }

    private function fieldBulmaDefaultConfig(): string
    {
        return Field::widget()
            ->config($this->personalForm, 'name')
            ->containerCssClass('field')
            ->hintCssClass('help')
            ->inputCssClass('input')
            ->labelCssClass('label')
            ->template("{label}<div class=\"control\">\n{input}</div>\n{hint}")
            ->render();
    }

    private function fieldTailwindDefaultConfig(): string
    {
        return Field::widget()
            ->config($this->personalForm, 'name')
            ->containerCssClass('grid grid-cols-1 gap-6')
            ->inputCssClass('mt-1 block w-full')
            ->labelCssClass('text-gray-700')
            ->nohint()
            ->template("<div class=\"block\">\n{label}{input}</div>\n")
            ->render();
    }

    private function getValidator(): Validator
    {
        return new Validator(new Formatter());
    }
}
