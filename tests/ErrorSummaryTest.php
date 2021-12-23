<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\LoginValidatorForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;
use Yii\Extension\Simple\Forms\ErrorSummary;

final class ErrorSummaryTest extends TestCase
{
    use TestTrait;

    public function dataProviderErrorSummary(): array
    {
        return [
            [
                'admin',
                'admin',
                [],
                '',
                '',
                true,
                '',
            ],
            [
                'admin',
                '1234',
                [],
                'Custom header',
                'Custom footer',
                true,
                <<<HTML
                <div>
                Custom header
                <ul>
                <li>invalid login password</li>
                </ul>
                Custom footer
                </div>
                HTML,
            ],
        ];
    }

    public function testImmutability(): void
    {
        $errorSummary = ErrorSummary::widget();
        $this->assertNotSame($errorSummary, $errorSummary->attributes([]));
        $this->assertNotSame($errorSummary, $errorSummary->encode(false));
        $this->assertNotSame($errorSummary, $errorSummary->footer(''));
        $this->assertNotSame($errorSummary, $errorSummary->header(''));
        $this->assertNotSame($errorSummary, $errorSummary->model(new LoginValidatorForm()));
        $this->assertNotSame($errorSummary, $errorSummary->showAllErrors(false));
        $this->assertNotSame($errorSummary, $errorSummary->tag('div'));
    }

    /**
     * @dataProvider dataProviderErrorSummary
     *
     * @param string $name
     * @param string $email
     * @param array $attributes
     * @param string $header
     * @param string $footer
     * @param bool $showAllErrors
     * @param string $expected
     */
    public function testErrorSummary(
        string $login,
        string $password,
        array $attributes,
        string $header,
        string $footer,
        bool $showAllErrors,
        string $expected
    ): void {
        $record = [
            'LoginValidatorForm' => [
                'login' => $login,
                'password' => $password,
            ],
        ];

        $formModel = new LoginValidatorForm();
        $formModel->load($record);

        $validator = $this->createValidatorMock();
        $validator->validate($formModel);

        $errorSummary = ErrorSummary::widget()
            ->attributes($attributes)
            ->model($formModel)
            ->footer($footer)
            ->showAllErrors($showAllErrors);

        $errorSummary = $header !== '' ? $errorSummary->header($header) : $errorSummary;

        $this->assertEqualsWithoutLE($expected, $errorSummary->render());
    }

    public function testTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        ErrorSummary::widget()->tag('')->render();
    }
}
