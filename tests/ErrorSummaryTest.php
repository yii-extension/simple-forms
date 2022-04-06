<?php

declare(strict_types=1);

namespace Yii\Extension\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Form\Exception\FormModelNotSetException;
use Yii\Extension\Form\ErrorSummary;
use Yii\Extension\Form\Tests\TestSupport\Form\CustomError;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;

final class ErrorSummaryTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetFormModelException(): void
    {
        $this->expectException(FormModelNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because form model is not set.');
        $this->invokeMethod(ErrorSummary::create(), 'getFormModel');
    }

    public function dataProviderErrorSummary(): array
    {
        return [
            // Default settings.
            [
                'jack@.com',
                'jac',
                'A258*f',
                [],
                '',
                ['class' => 'text-danger'],
                '',
                [],
                true,
                [],
                <<<HTML
                <div>
                <p class="text-danger">Please fix the following errors:</p>
                <ul>
                <li>This value is not a valid email address.</li>
                <li>Is too short.</li>
                <li>Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters.</li>
                </ul>
                </div>
                HTML,
            ],
            // Set custom header and custom footer.
            [
                'jack@.com',
                'jac',
                'A258*f',
                [],
                'Custom header',
                ['class' => 'text-danger'],
                'Custom footer',
                ['class' => 'text-primary'],
                true,
                [],
                <<<HTML
                <div>
                <p class="text-danger">Custom header</p>
                <ul>
                <li>This value is not a valid email address.</li>
                <li>Is too short.</li>
                <li>Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters.</li>
                </ul>
                <p class="text-primary">Custom footer</p>
                </div>
                HTML,
            ],
            // Set only attributes with showAllErros its `true`.
            [
                'jack@.com',
                'jac',
                'A258*f',
                [],
                '',
                ['class' => 'text-danger'],
                '',
                ['class' => 'text-primary'],
                true,
                ['login'],
                <<<HTML
                <div>
                <p class="text-danger">Please fix the following errors:</p>
                <ul>
                <li>Is too short.</li>
                </ul>
                </div>
                HTML,
            ],
            // Set only attributes with showAllErros `false`.
            [
                'jack@.com',
                'jac',
                'A258*f',
                [],
                '',
                ['class' => 'text-danger'],
                '',
                ['class' => 'text-primary'],
                false,
                ['password'],
                <<<HTML
                <div>
                <p class="text-danger">Please fix the following errors:</p>
                <ul>
                <li>Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters.</li>
                </ul>
                </div>
                HTML,
            ],
        ];
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $errorSummary = ErrorSummary::create();
        $this->assertNotSame($errorSummary, $errorSummary->encode(false));
        $this->assertNotSame($errorSummary, $errorSummary->footer(''));
        $this->assertNotSame($errorSummary, $errorSummary->header(''));
        $this->assertNotSame($errorSummary, $errorSummary->model(new CustomError()));
        $this->assertNotSame($errorSummary, $errorSummary->onlyAttributes(''));
        $this->assertNotSame($errorSummary, $errorSummary->showAllErrors(false));
        $this->assertNotSame($errorSummary, $errorSummary->tag('div'));
    }

    /**
     * @dataProvider dataProviderErrorSummary
     *
     * @param string $login
     * @param string $email
     * @param string $password
     * @param array $attributes
     * @param string $header
     * @param array $headerAttributes
     * @param string $footer
     * @param array $footerAttributes
     * @param bool $showAllErrors
     * @param array $onlyAttributes
     * @param string $expected
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testErrorSummary(
        string $email,
        string $login,
        string $password,
        array $attributes,
        string $header,
        array $headerAttributes,
        string $footer,
        array $footerAttributes,
        bool $showAllErrors,
        array $onlyAttributes,
        string $expected
    ): void {
        $formModel = new CustomError();

        $record = [
            'CustomError' => [
                'email' => $email,
                'login' => $login,
                'password' => $password,
            ],
        ];

        $formModel->load($record);
        $formModel->validate();
        $errorSummary = ErrorSummary::create()
            ->attributes($attributes)
            ->onlyAttributes(...$onlyAttributes)
            ->footer($footer)
            ->footerAttributes($footerAttributes)
            ->headerAttributes($headerAttributes)
            ->model($formModel)
            ->showAllErrors($showAllErrors);

        $errorSummary = $header !== '' ? $errorSummary->header($header) : $errorSummary;

        $this->assertEqualsWithoutLE($expected, $errorSummary->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        ErrorSummary::create()->tag('')->render();
    }
}
