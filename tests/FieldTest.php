<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;
use Yii\Extension\Simple\Forms\Field;

final class FieldTest extends TestCase
{
    public function testRenderBootstrap5(): void
    {
        $model = new PersonalForm();

        $html = Field::widget()->config($model, 'name')->bootstrap()->render();

        $expected = <<<HTML
        <div class="mb-3">
        <label class="form-label" for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" value="" aria-describedby="personalform-name-hint" placeholder="Name" required>
        <div id="personalform-name-hint" class="form-text">Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderBulma(): void
    {
        $model = new PersonalForm();

        $html = Field::widget()->config($model, 'name')->bulma()->render();

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
        $model = new PersonalForm();

        $html = Field::widget()->config($model, 'name')->tailwind()->render();

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
}
