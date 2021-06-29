<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;
use Yiisoft\Validator\Formatter;
use Yiisoft\Validator\Validator;

final class FieldTest extends TestCase
{
    private PersonalForm $personalForm;

    protected function setUp(): void
    {
        $this->personalForm = new PersonalForm();
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

    private function fieldBoostrapDefaultConfig(): string
    {
        return Field::widget()
            ->config(new PersonalForm(), 'name')
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
