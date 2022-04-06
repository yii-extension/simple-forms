<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Fieldset;
use Yii\Extension\Form\Form;
use Yii\Extension\Form\Tests\TestSupport\Form\FieldSetForm;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Html;

final class FieldsetTest extends TestCase
{
    use TestTrait;

    private array $state = [1 => 'Draft', 2 => 'In Progress', 3 => 'Done', 4 => 'Discarded'];

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame('<fieldset autofocus>', Fieldset::create()->autofocus()->begin());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAttributes(): void
    {
        $this->assertSame(
            '<fieldset class="test-class">',
            Fieldset::create()->attributes(['class' => 'test-class'])->begin(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testClass(): void
    {
        $this->assertSame('<fieldset class="test-class">', Fieldset::create()->class('test-class')->begin());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame('<fieldset disabled>', Fieldset::create()->disabled()->begin());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame('<fieldset id="id-test">', Fieldset::create()->id('id-test')->begin());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $fieldset = Fieldset::create();
        $this->assertNotSame($fieldset, $fieldset->autofocus());
        $this->assertNotSame($fieldset, $fieldset->class(''));
        $this->assertNotSame($fieldset, $fieldset->disabled());
        $this->assertNotSame($fieldset, $fieldset->id(null));
        $this->assertNotSame($fieldset, $fieldset->legend(null));
        $this->assertNotSame($fieldset, $fieldset->legendAttributes([]));
        $this->assertNotSame($fieldset, $fieldset->name(null));
        $this->assertNotSame($fieldset, $fieldset->title(''));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame('<fieldset name="name-test">', Fieldset::create()->name('name-test')->begin());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @link https://jsfiddle.net/6fz3nvLr/
     */
    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.6/build/pure-min.css" integrity="sha384-Uu6IeWbM+gzNVXJcM9XV3SohHtmWE+3VGi496jvgX1jyvDTXfdK+rfZc8C1Aehk5" crossorigin="anonymous">
        <div class="pure-g" style="position: absolute;top: 50%;left: 50%;transform:translate(-50%,-50%);">
        <div class="pure-u-5-5">
        <form class="pure-form" action="#" method="GET">
        <fieldset name="field-set-main">
        <legend>Create A Project</legend>
        <input type="text" id="fieldsetform-name" name="FieldSetForm[name]" placeholder="name">
        <div>
        <input type="datetime-local" id="fieldsetform-start" name="FieldSetForm[start]">
        <input type="datetime-local" id="fieldsetform-end" name="FieldSetForm[end]">
        </div>
        </fieldset>
        <fieldset name="field-set-state">
        <legend>State</legend>
        <div>
        <div id="fieldsetform-state">
        <label><input type="radio" name="FieldSetForm[state]" value="Draft"> Draft</label>
        <label><input type="radio" name="FieldSetForm[state]" value="In Progress"> In Progress</label>
        <label><input type="radio" name="FieldSetForm[state]" value="Done"> Done</label>
        <label><input type="radio" name="FieldSetForm[state]" value="Discarded"> Discarded</label>
        </div>
        </div>
        </fieldset>
        <fieldset name="field-set-description">
        <legend>Description</legend>
        <textarea id="fieldsetform-description" name="FieldSetForm[description]" rows="5" cols="50" placeholder="Write Description here.." style="width: 100%"></textarea>
        </fieldset>
        <fieldset name="field-set-control">
        <legend>Action</legend>
        <div>
        <input type="submit" id="w1-button" class="pure-button pure-button-primary" name="w1-button" value="Submit">
        <input type="submit" id="w2-button" class="pure-button pure-button-danger" name="w2-button" value="Cancel">
        </div>
        </fieldset>
        </form>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            '<link rel="stylesheet" href="https://unpkg.com/purecss@2.0.6/build/pure-min.css" integrity="sha384-Uu6IeWbM+gzNVXJcM9XV3SohHtmWE+3VGi496jvgX1jyvDTXfdK+rfZc8C1Aehk5" crossorigin="anonymous">' . PHP_EOL .
            '<div class="pure-g" style="position: absolute;top: 50%;left: 50%;transform:translate(-50%,-50%);">' . PHP_EOL .
            '<div class="pure-u-5-5">' . PHP_EOL .
            Form::create()->action('#')->class('pure-form')->method('get')->begin() . PHP_EOL .
                Fieldset::create()->legend('Create A Project')->name('field-set-main')->begin() . PHP_EOL .
                    Field::create()
                        ->container(false)
                        ->label(null)
                        ->placeholder('name')
                        ->text(new FieldSetForm(), 'name')
                        ->render() . PHP_EOL .
                    '<div>' . PHP_EOL .
                    Field::create()
                        ->container(false)
                        ->dateTimeLocal(new FieldSetForm(), 'start')
                        ->label(null)
                        ->render() . PHP_EOL .
                    Field::create()
                        ->container(false)
                        ->dateTimeLocal(new FieldSetForm(), 'end')
                        ->label(null)
                        ->render() . PHP_EOL .
                    '</div>' . PHP_EOL .
                Fieldset::end() .
                Fieldset::create()->legend('State')->name('field-set-state')->begin() . PHP_EOL .
                    Field::create()
                        ->label(null)
                        ->radioList(new FieldSetForm(), 'state', ['itemsFromValues()' => [$this->state]])
                        ->render() . PHP_EOL .
                Fieldset::end() .
                Fieldset::create()->legend('Description')->name('field-set-description')->begin() . PHP_EOL .
                    Field::create()
                        ->attributes(['cols' => 50, 'rows' => 5, 'style' => 'width: 100%'])
                        ->container(false)
                        ->label(null)
                        ->placeholder('Write Description here..')
                        ->textArea(new FieldSetForm(), 'description')
                        ->render() . PHP_EOL .
                Fieldset::end() .
                Fieldset::create()->legend('Action')->name('field-set-control')->begin() . PHP_EOL .
                    Field::create()
                        ->container(false)
                        ->buttonGroup(
                            [
                                ['label' => 'Submit', 'type' => 'submit'],
                                ['label' => 'Cancel', 'type' => 'submit'],
                            ],
                            [
                                'individualButtonAttributes()' => [
                                    [
                                        0 => ['class' => 'pure-button pure-button-primary'],
                                        1 => ['class' => 'pure-button pure-button-danger'],
                                    ],
                                ],
                            ],
                        ) . PHP_EOL .
                Fieldset::end() .
            Form::end() . PHP_EOL .
            '</div>' . PHP_EOL .
            '</div>',
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTitle(): void
    {
        $this->assertSame('<fieldset title="your title">', Fieldset::create()->title('your title')->begin());
    }
}
