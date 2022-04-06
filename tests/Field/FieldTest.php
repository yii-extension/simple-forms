<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget\Field;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Tests\TestSupport\Form\PropertyType;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Tag\Input;
use Yiisoft\Html\Tag\Span;

final class FieldTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerAttributes(): void
    {
        $expected = <<<HTML
        <div id="id-test" class="test-class">
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->containerId('id-test')
                ->containerAttributes(['class' => 'test-class'])
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerId(): void
    {
        $expected = <<<HTML
        <div id="id-test">
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->containerId('id-test')->text(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerName(): void
    {
        $expected = <<<HTML
        <div name="name-test">
        <label for="propertytype-string">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->containerName('name-test')->text(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/forms/input-group/
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDefaultTokens(): void
    {
        $expected = <<<HTML
        <div class="input-group mb-3">
        <span class="input-group-text">.00</span>
        <input type="text" id="propertytype-string" class="form-control" name="PropertyType[string]" aria-describedby="propertytype-string-help" aria-label="Amount (to the nearest dollar)">
        <span class="input-group-text">$</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->ariaDescribedBy(true)
                ->ariaLabel('Amount (to the nearest dollar)')
                ->containerClass('input-group mb-3')
                ->defaultTokens(
                    [
                        '{after}' => Span::tag()->class('input-group-text')->content('$'),
                        '{before}' => Span::tag()->class('input-group-text')->content('.00'),
                    ]
                )
                ->inputClass('form-control')
                ->template("{before}\n{input}\n{after}\n{hint}\n{error}")
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDefaultTokensWithOverrideToken(): void
    {
        $expected = <<<HTML
        <div>
        <label for="propertytype-string">String</label>
        <input type="color" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()
                ->defaultTokens(
                    [
                        '{input}' => Input::tag()->id('propertytype-string')->name('PropertyType[string]')->type('color'),
                    ]
                )
                ->template("{label}\n{input}\n{hint}\n{error}")
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/forms/input-group/
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDefaultTokensWithDefaultValues(): void
    {
        $factoryConfig = [
            'defaultValues()' => [
                [
                    'text' => [
                        'defaultTokens' => [
                            '{after}' => Span::tag()->class('input-group-text')->content('$'),
                            '{before}' => Span::tag()->class('input-group-text')->content('.00'),
                        ],
                        'template' => "{before}\n{input}\n{after}\n{error}",
                    ],
                    'textArea' => [
                        'defaultTokens' => [
                            '{before}' => Span::tag()->class('input-group-text')->content('With textarea'),
                        ],
                        'template' => "{before}\n{input}\n{error}",
                    ],
                ],
            ],
        ];

        $field = Field::create($factoryConfig);

        $expected = <<<HTML
        <div class="input-group mb-3">
        <span class="input-group-text">.00</span>
        <input type="text" id="propertytype-string" class="form-control" name="PropertyType[string]" aria-describedby="propertytype-string-help" aria-label="Amount (to the nearest dollar)">
        <span class="input-group-text">$</span>
        </div>
        <div class="input-group">
        <span class="input-group-text">With textarea</span>
        <textarea id="propertytype-string" name="PropertyType[string]"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            $field
                ->ariaDescribedBy(true)
                ->ariaLabel('Amount (to the nearest dollar)')
                ->containerClass('input-group mb-3')
                ->inputClass('form-control')
                ->text(new PropertyType(), 'string')
                ->render() . PHP_EOL .
            $field
                ->containerClass('input-group')
                ->textArea(new PropertyType(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLabelFor(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">String</label>
        <input type="text" id="propertytype-string" name="PropertyType[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create()->labelFor('id-test')->text(new PropertyType(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReplaceIndividualToken(): void
    {
        $factoryConfig = [
            'defaultTokens()' => [
                [
                    '{after}' => Span::tag()->class('input-group-text')->content('$'),
                    '{before}' => Span::tag()->class('input-group-text')->content('.00'),
                ],
            ],
        ];

        $expected = <<<HTML
        <div class="input-group mb-3">
        <span class="input-group-text">.00</span>
        <input type="text" id="propertytype-string" class="form-control" name="PropertyType[string]" aria-describedby="propertytype-string-help" aria-label="Amount (to the nearest dollar)">
        <span class="input-group-text">€</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create($factoryConfig)
                ->ariaDescribedBy(true)
                ->ariaLabel('Amount (to the nearest dollar)')
                ->containerClass('input-group mb-3')
                ->inputClass('form-control')
                ->replaceIndividualToken('{after}', '<span class="input-group-text">€</span>')
                ->template("{before}\n{input}\n{after}\n{hint}\n{error}")
                ->text(new PropertyType(), 'string')
                ->render(),
        );

        $expected = <<<HTML
        <div class="input-group mb-3">
        <span class="input-group-text">.00</span>
        <input type="text" id="propertytype-string" class="form-control" name="PropertyType[string]" aria-describedby="propertytype-string-help" aria-label="Amount (to the nearest dollar)">
        <span class="input-group-text">€</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::create($factoryConfig)
                ->ariaDescribedBy(true)
                ->ariaLabel('Amount (to the nearest dollar)')
                ->containerClass('input-group mb-3')
                ->inputClass('form-control')
                ->replaceIndividualToken(
                    '{after}',
                    new class () {
                        public function __toString(): string
                        {
                            return '<span class="input-group-text">€</span>';
                        }
                    }
                )
                ->template("{before}\n{input}\n{after}\n{hint}\n{error}")
                ->text(new PropertyType(), 'string')
                ->render(),
        );
    }
}
