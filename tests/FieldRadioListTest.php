<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\TypeForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Widget\RadioList\RadioItem;

final class FieldRadioListTest extends TestCase
{
    use TestTrait;

    private array $sex = [1 => 'Female', 2 => 'Male'];
    private TypeForm $model;

    public function testContainerAttributes(): void
    {
        $this->model->setAttribute('int', 2);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int" class="test-class">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'int')
            ->radioList(['containerAttributes' => ['class' => 'test-class']], $this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testContainerTag(): void
    {
        $this->model->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <span id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1" checked> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </span>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'int')
            ->radioList(['containerTag' => 'span'], $this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testContainerTagWithFalse(): void
    {
        $this->model->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <label><input type="radio" name="TypeForm[int]" value="1" checked> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'int')
            ->radioList(['containerTag' => false], $this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDisabled(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1" disabled> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2" disabled> Male</label>
        </div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'int')
            ->radioList(['disabled' => true], $this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testForceUncheckedValue(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <input type="hidden" name="TypeForm[int]" value="0">
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'int')
            ->radioList(['forceUncheckedValue' => '0'], $this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testIndividualItemsAttributes(): void
    {
        $this->model->setAttribute('int', 2);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1" disabled> Female</label>
        <label><input type="radio" class="test-class" name="TypeForm[int]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'int')
            ->radioList(
                [
                    'individualItemsAttributes' => [1 => ['disabled' => true], 2 => ['class' => 'test-class']],
                ],
                $this->sex,
            )
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemsAttributes(): void
    {
        $this->model->setAttribute('int', 2);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" class="test-class" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" class="test-class" name="TypeForm[int]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'int')
            ->radioList(['itemsAttributes' => ['class' => 'test-class']], $this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemFormater(): void
    {
        $this->model->setAttribute('int', 2);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type='checkbox' name='TypeForm[int]' value='1'> Female</label>
        <label><input type='checkbox' name='TypeForm[int]' value='2' checked> Male</label>
        </div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'int')
            ->radioList(
                [
                    'itemsFormatter' => static function (RadioItem $item) {
                        return $item->checked
                            ? "<label><input type='checkbox' name='{$item->name}' value='{$item->value}' checked> {$item->label}</label>"
                            : "<label><input type='checkbox' name='{$item->name}' value='{$item->value}'> {$item->label}</label>";
                    },
                ],
                $this->sex
            )
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testReadOnly(): void
    {
        $this->model->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1" checked readonly> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2" readonly> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'int')->radioList(['readonly' => true], $this->sex)->render(),
        );
    }

    public function testRender(): void
    {
        $this->model->setAttribute('int', 2);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'int')->radioList([], $this->sex)->render(),
        );
    }

    public function testSeparator(): void
    {
        $this->model->setAttribute('int', 2);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->model, 'int')
            ->radioList(['separator' => PHP_EOL], $this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testValue(): void
    {
        // value bool false
        $this->model->setAttribute('bool', false);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-bool">Bool</label>
        <div id="typeform-bool">
        <label><input type="radio" name="TypeForm[bool]" value="0" checked> Female</label>
        <label><input type="radio" name="TypeForm[bool]" value="1"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'bool')->radioList([], [0 => 'Female', 1 => 'Male'])->render(),
        );

        // value bool true
        $this->model->setAttribute('bool', true);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-bool">Bool</label>
        <div id="typeform-bool">
        <label><input type="radio" name="TypeForm[bool]" value="0"> Female</label>
        <label><input type="radio" name="TypeForm[bool]" value="1" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'bool')->radioList([], [0 => 'Female', 1 => 'Male'])->render(),
        );

        // value int 0
        $this->model->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1" checked> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'int')->radioList([], $this->sex)->render(),
        );

        // value int 1
        $this->model->setAttribute('int', 2);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'int')->radioList([], $this->sex)->render(),
        );

        // value string '1'
        $this->model->setAttribute('string', '1');
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="1" checked> Female</label>
        <label><input type="radio" name="TypeForm[string]" value="2"> Male</label>
        </div>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->radioList([], $this->sex)->render(),
        );

        // value string '2'
        $this->model->setAttribute('string', '2');
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[string]" value="2" checked> Male</label>
        </div>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'string')->radioList([], $this->sex)->render(),
        );

        // value null
        $this->model->setAttribute('toNull', null);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-tonull">To Null</label>
        <div id="typeform-tonull">
        <label><input type="radio" name="TypeForm[toNull]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[toNull]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->model, 'toNull')->radioList([], $this->sex)->render(),
        );
    }

    public function testValueException(): void
    {
        $this->model->setAttribute('array', []);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('RadioList widget required bool|float|int|string|null.');
        $html = Field::widget()->config($this->model, 'array')->radioList()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TypeForm();
    }
}
