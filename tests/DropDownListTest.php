<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\DropDownList;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class DropDownListTest extends TestCase
{
    use TestTrait;

    private PersonalForm $data;
    private array $cities = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new PersonalForm();

        $this->cities = [
            '1' => 'Moscu',
            '2' => 'San Petersburgo',
            '3' => 'Novosibirsk',
            '4' => 'Ekaterinburgo',
        ];
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->cities, $this->model);
    }

    public function testListGroups(): void
    {
        $groups = [
            '1' => ['label' => 'Russia'],
            '2' => ['label' => 'Chile'],
        ];

        $this->cities = [
            '1' => [
                '2' => ' Moscu',
                '3' => ' San Petersburgo',
                '4' => ' Novosibirsk',
                '5' => ' Ekaterinburgo',
            ],
            '2' => [
                '6' => 'Santiago',
                '7' => 'Concepcion',
                '8' => 'Chillan',
            ],
        ];

        $this->model->setAttribute('cityBirth', 1);

        $html = DropDownList::widget()
            ->config($this->model, 'cityBirth')
            ->items($this->cities)
            ->groups($groups)
            ->render();
        $expected = <<<'HTML'
        <select id="personalform-citybirth" name="PersonalForm[cityBirth]">
        <optgroup label="Russia">
        <option value="2"> Moscu</option>
        <option value="3"> San Petersburgo</option>
        <option value="4"> Novosibirsk</option>
        <option value="5"> Ekaterinburgo</option>
        </optgroup>
        <optgroup label="Chile">
        <option value="6">Santiago</option>
        <option value="7">Concepcion</option>
        <option value="8">Chillan</option>
        </optgroup>
        </select>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListGroupsItemsAttributes(): void
    {
        $groups = [
            '1' => ['class' => 'text-danger', 'label' => 'Russia'],
            '2' => ['class' => 'text-primary', 'label' => 'Chile'],
        ];

        $this->cities = [
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

        $this->model->setAttribute('cityBirth', 1);

        $html = DropDownList::widget()
            ->config($this->model, 'cityBirth')
            ->items($this->cities)
            ->itemsAttributes(['2' => ['disabled' => true]])
            ->groups($groups)
            ->render();
        $expected = <<<'HTML'
        <select id="personalform-citybirth" name="PersonalForm[cityBirth]">
        <optgroup class="text-danger" label="Russia">
        <option value="2" disabled>Moscu</option>
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
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testMultiple(): void
    {
        $this->model->setAttribute('cityBirth', 4);

        $html = DropDownList::widget()
            ->config($this->model, 'cityBirth')
            ->items($this->cities)
            ->multiple()
            ->render();
        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[cityBirth]" value="">
        <select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="4">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4" selected>Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testPrompt(): void
    {
        $prompt = [
            'text' => 'Select City Birth',
            'attributes' => [
                'value' => '0',
                'selected' => 'selected',
            ],
        ];

        $html = DropDownList::widget()
            ->config($this->model, 'cityBirth')
            ->items($this->cities)
            ->prompt($prompt)
            ->render();
        $expected = <<<'HTML'
        <select id="personalform-citybirth" name="PersonalForm[cityBirth]">
        <option value="0" selected>Select City Birth</option>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRender(): void
    {
        $this->model->setAttribute('cityBirth', 2);

        $html = DropdownList::widget()->config($this->model, 'cityBirth')->items($this->cities)->render();
        $expected = <<<'HTML'
        <select id="personalform-citybirth" name="PersonalForm[cityBirth]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testSizeWithMultiple(): void
    {
        $this->model->setAttribute('cityBirth', 2);

        $html = DropDownList::widget()
            ->config($this->model, 'cityBirth')
            ->items($this->cities)
            ->multiple()
            ->size(3)
            ->render();
        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[cityBirth]" value="">
        <select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="3">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testUnselectWithMultiple(): void
    {
        $this->model->setAttribute('cityBirth', 2);

        $html = DropDownList::widget()
            ->config($this->model, 'cityBirth')
            ->items($this->cities)
            ->multiple()
            ->unselectValue('0')
            ->render();
        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[cityBirth]" value="0">
        <select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="4">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
