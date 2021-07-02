<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\CheckBoxList;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class CheckBoxListTest extends TestCase
{
    use TestTrait;

    public function testCheckBoxListItemsAttributes(): void
    {
        $html = CheckboxList::widget()
            ->config(new PersonalForm(), 'cityBirth')
            ->items(['Moscu', 'San Petesburgo'])
            ->itemsAttributes(['class' => 'itemClass'])
            ->render();
        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[cityBirth]" value="">
        <div id="personalform-citybirth">
        <label><input type="checkbox" class="itemClass" name="PersonalForm[cityBirth][]" value="0"> Moscu</label>
        <label><input type="checkbox" class="itemClass" name="PersonalForm[cityBirth][]" value="1"> San Petesburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testContainerAttributes(): void
    {
        $html = CheckboxList::widget()
            ->config(new PersonalForm(), 'cityBirth')
            ->containerAttributes(['class' => 'text-danger'])
            ->items(['Moscu', 'San Petesburgo'])
            ->render();
        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[cityBirth]" value="">
        <div id="personalform-citybirth" class="text-danger">
        <label><input type="checkbox" name="PersonalForm[cityBirth][]" value="0"> Moscu</label>
        <label><input type="checkbox" name="PersonalForm[cityBirth][]" value="1"> San Petesburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemFormater(): void
    {
        $html = CheckboxList::widget()
            ->config(new PersonalForm(), 'cityBirth')
            ->items(['Moscu', 'San Petesburgo'])
            ->itemFormater(static function (CheckboxItem $item) {
                return "<div class='col-sm-12'><label><input tabindex='{$item->index}' class='book' type='checkbox' name='{$item->name}' value='{$item->value}'> {$item->label}</label></div>";
            })
            ->render();
        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[cityBirth]" value="">
        <div id="personalform-citybirth">
        <div class='col-sm-12'><label><input tabindex='0' class='book' type='checkbox' name='PersonalForm[cityBirth][]' value='0'> Moscu</label></div>
        <div class='col-sm-12'><label><input tabindex='1' class='book' type='checkbox' name='PersonalForm[cityBirth][]' value='1'> San Petesburgo</label></div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCheckBoxListNoUnselect(): void
    {
        $html = CheckboxList::widget()
            ->config(new PersonalForm(), 'cityBirth')
            ->items(['Moscu', 'San Petesburgo'])
            ->noUnselect()
            ->render();
        $expected = <<<'HTML'
        <div id="personalform-citybirth">
        <label><input type="checkbox" name="PersonalForm[cityBirth][]" value="0"> Moscu</label>
        <label><input type="checkbox" name="PersonalForm[cityBirth][]" value="1"> San Petesburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testReadOnly(): void
    {
        $html = CheckboxList::widget()
            ->config(new PersonalForm(), 'cityBirth')
            ->items(['Moscu'])
            ->readOnly()
            ->render();
        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[cityBirth]" value="">
        <div id="personalform-citybirth">
        <label><input type="checkbox" name="PersonalForm[cityBirth][]" value="0" readonly> Moscu</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRender(): void
    {
        $model = new PersonalForm();
        $model->setAttribute('cityBirth', 1);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[cityBirth]" value="">
        <div id="personalform-citybirth">
        <label><input type="checkbox" name="PersonalForm[cityBirth][]" value="0"> Moscu</label>
        <label><input type="checkbox" name="PersonalForm[cityBirth][]" value="1" checked> San Petesburgo</label>
        </div>
        HTML;
        $html = CheckboxList::widget()->config($model, 'cityBirth')->items(['Moscu', 'San Petesburgo'])->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testSeparator(): void
    {
        $html = CheckboxList::widget()
            ->config(new PersonalForm(), 'cityBirth')
            ->items(['Moscu', 'San Petesburgo'])
            ->separator('&#9866;')
            ->render();
        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[cityBirth]" value="">
        <div id="personalform-citybirth">
        <label><input type="checkbox" name="PersonalForm[cityBirth][]" value="0"> Moscu</label>&#9866;<label><input type="checkbox" name="PersonalForm[cityBirth][]" value="1"> San Petesburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testUnselect(): void
    {
        $html = CheckboxList::widget()
            ->config(new PersonalForm(), 'cityBirth')
            ->items(['Moscu', 'San Petesburgo'])
            ->unselect('0')
            ->render();
        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[cityBirth]" value="0">
        <div id="personalform-citybirth">
        <label><input type="checkbox" name="PersonalForm[cityBirth][]" value="0"> Moscu</label>
        <label><input type="checkbox" name="PersonalForm[cityBirth][]" value="1"> San Petesburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testWithoutContainer(): void
    {
        $html = CheckboxList::widget()
            ->config(new PersonalForm(), 'cityBirth')
            ->items(['Moscu'])
            ->noUnselect()
            ->withoutContainer()
            ->render();
        $this->assertSame(
            '<label><input type="checkbox" name="PersonalForm[cityBirth][]" value="0"> Moscu</label>',
            $html,
        );
    }
}
