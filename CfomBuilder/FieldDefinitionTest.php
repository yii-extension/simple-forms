<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Field;
use Yii\Extension\Simple\Forms\Password;
use Yii\Extension\Simple\Forms\Text;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\LoginForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldDefinitionTest extends TestCase
{
    use TestTrait;

    public function testDefinition(): void {
        // Set factory definition widget.
        $this->FactoryWidget(
            [
                Field::class => [
                    'containerClass()' => ['mb-3'],
                    'errorClass()' => ['hasError'],
                    'hintClass()' => ['info-class'],
                    'invalidClass()' => ['is-invalid'],
                    'inputClass()' => ['form-control'],
                    'labelClass()' => ['form-label'],
                    'validClass()' => ['is-valid'],
                ],

                Password::class => [
                    'containerClass()' => ['form-group mb-3"'],
                    'inputClass()' => ['input-group'],
                    'template()' => ["{input}\n{label}\n{hint}]n{error}"],
                ],
            ]
        );

        $expected = <<<HTML
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->text(new LoginForm(), 'login')->render() . PHP_EOL .
            Field::widget()->password(new LoginForm(), 'password')->render(),
        );
    }

    private function factoryWidget(array $definitions): void
    {
        WidgetFactory::initialize(new SimpleContainer(), $definitions);
    }
}
