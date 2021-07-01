<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yii\Extension\Simple\Forms\TextArea;

final class TextAreaTest extends TestCase
{
    public function testMaxLength(): void
    {
        $model = new PersonalForm();

        $html = TextArea::widget()->config($model, 'name')->maxlength(50)->render();
        $expected = <<<'HTML'
        <textarea id="personalform-name" name="PersonalForm[name]" maxlength="50" placeholder="Name"></textarea>
        HTML;
        $this->assertEquals($expected, $html);
    }

    public function testMinLength(): void
    {
        $model = new PersonalForm();

        $html = TextArea::widget()->config($model, 'name')->minlength(10)->render();
        $expected = <<<'HTML'
        <textarea id="personalform-name" name="PersonalForm[name]" minlength="10" placeholder="Name"></textarea>
        HTML;
        $this->assertEquals($expected, $html);
    }

    public function testRender(): void
    {
        $model = new PersonalForm();

        $html = TextArea::widget()->config($model, 'name')->render();
        $expected = <<<'HTML'
        <textarea id="personalform-name" name="PersonalForm[name]" placeholder="Name"></textarea>
        HTML;
        $this->assertEquals($expected, $html);
    }

    public function testReadOnly(): void
    {
        $model = new PersonalForm();

        $html = TextArea::widget()->config($model, 'name')->readOnly()->render();
        $expected = <<<'HTML'
        <textarea id="personalform-name" name="PersonalForm[name]" readonly placeholder="Name"></textarea>
        HTML;
        $this->assertEquals($expected, $html);
    }

    public function testSpellCheck(): void
    {
        $model = new PersonalForm();

        $html = TextArea::widget()->config($model, 'name')->spellcheck()->render();
        $expected = <<<'HTML'
        <textarea id="personalform-name" name="PersonalForm[name]" spellcheck placeholder="Name"></textarea>
        HTML;
        $this->assertEquals($expected, $html);
    }

    public function testTitle(): void
    {
        $model = new PersonalForm();

        $html = TextArea::widget()
            ->config($model, 'name')
            ->title('Enter the city, municipality, avenue, house or apartment number.')
            ->render();
        $expected = <<<'HTML'
        <textarea id="personalform-name" name="PersonalForm[name]" title="Enter the city, municipality, avenue, house or apartment number." placeholder="Name"></textarea>
        HTML;
        $this->assertEquals($expected, $html);
    }
}
