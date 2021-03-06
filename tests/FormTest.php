<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Stringable;
use Yii\Extension\Form\Form;
use Yii\Extension\Form\Tests\TestSupport\TestTrait;

final class FormTest extends TestCase
{
    use TestTrait;

    /**
     * @throws ReflectionException
     */
    public function testAcceptCharset(): void
    {
        $this->assertSame(
            '<form method="POST" accept-charset="UTF-8">',
            Form::create()->acceptCharset('UTF-8')->begin(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testAction(): void
    {
        $this->assertSame('<form action="/test" method="POST">', Form::create()->action('/test')->begin());
    }

    /**
     * @throws ReflectionException
     */
    public function testAttributes(): void
    {
        $this->assertSame(
            '<form class="test-class" method="POST">',
            Form::create()->attributes(['class' => 'test-class'])->begin(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testAutocomplete(): void
    {
        /** on value */
        $this->assertSame(
            '<form method="POST" autocomplete="on">',
            Form::create()->autocomplete()->begin(),
        );
        /** off value */
        $this->assertSame(
            '<form method="POST" autocomplete="off">',
            Form::create()->autocomplete(false)->begin(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testBegin(): void
    {
        $this->assertSame('<form method="POST">', Form::create()->begin());
        $hiddens = [
            '<input type="hidden" name="id" value="1">',
            '<input type="hidden" name="title" value="&lt;">',
        ];
        $this->assertSame(
            '<form action="/example" method="GET">' . PHP_EOL . implode(PHP_EOL, $hiddens),
            Form::create()->action('/example?id=1&title=%3C')->method('GET')->begin()
        );
        $this->assertStringMatchesFormat(
            '<form action="/foo" method="GET">%A<input type="hidden" name="p" value>',
            Form::create()->action('/foo?p')->method('GET')->begin(),
        );
    }

    /**
     * Data provider for {@see testCsrf()}.
     *
     * @return array test data
     */
    public function dataProviderCsrf(): array
    {
        return [
            // empty csrf name and token
            ['<form action="/foo" method="POST">', 'POST', '', ''],
            // empty csrf token
            ['<form action="/foo" method="POST">', 'POST', '', 'myToken'],
            // only csrf token value
            ['<form action="/foo" method="GET" _csrf="tokenCsrf">', 'GET', 'tokenCsrf', ''],
            // only csrf custom name
            [
                '<form action="/foo" method="POST" myToken="tokenCsrf">' . PHP_EOL .
                '<input type="hidden" name="myToken" value="tokenCsrf">',
                'POST',
                'tokenCsrf',
                'myToken',
            ],
            // object stringable
            [
                '<form action="/foo" method="POST" myToken="tokenCsrf">' . PHP_EOL .
                '<input type="hidden" name="myToken" value="tokenCsrf">',
                'POST',
                new class () {
                    public function __toString(): string
                    {
                        return 'tokenCsrf';
                    }
                },
                'myToken',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderCsrf
     *
     * @param string $expected
     * @param string $method
     * @param string|Stringable $csrfToken
     * @param string $csrfName
     *
     * @throws ReflectionException
     */
    public function testCsrf(string $expected, string $method, $csrfToken, string $csrfName): void
    {
        $formWidget = $csrfName !== ''
            ? Form::create()->action('/foo')->csrf($csrfToken, $csrfName)->method($method)->begin()
            : Form::create()->action('/foo')->csrf($csrfToken)->method($method)->begin();
        $this->assertSame($expected, $formWidget);
    }

    /**
     * @throws ReflectionException
     */
    public function testEnd(): void
    {
        Form::create()->begin();
        $this->assertSame('</form>', Form::end());
    }

    /**
     * @throws ReflectionException
     */
    public function testEnctype(): void
    {
        $this->assertSame(
            '<form id="multipart/form-data" method="POST">',
            Form::create()->enctype('multipart/form-data')->begin(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        $this->assertSame('<form id="form-id" method="POST">', Form::create()->id('form-id')->begin());
        $this->assertSame(
            '<form id="form-id" method="POST">',
            Form::create()->attributes(['id' => 'form-id'])->begin(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testImmutability(): void
    {
        $form = Form::create();
        $this->assertNotSame($form, $form->acceptCharset(''));
        $this->assertNotSame($form, $form->action(''));
        $this->assertNotSame($form, $form->autocomplete());
        $this->assertNotSame($form, $form->csrf(''));
        $this->assertNotSame($form, $form->class(''));
        $this->assertNotSame($form, $form->enctype(''));
        $this->assertNotSame($form, $form->id(''));
        $this->assertNotSame($form, $form->method(''));
        $this->assertNotSame($form, $form->noHtmlValidation());
        $this->assertNotSame($form, $form->target(''));
    }

    /**
     * @throws ReflectionException
     */
    public function testMethod(): void
    {
        $this->assertSame('<form method="GET">', Form::create()->method('get')->begin());
        $this->assertSame('<form method="POST">', Form::create()->method('post')->begin());
    }

    /**
     * @throws ReflectionException
     */
    public function testNoHtmlValidatation(): void
    {
        $this->assertSame('<form method="POST" novalidate>', Form::create()->noHtmlValidation()->begin());
    }

    /**
     * @throws ReflectionException
     */
    public function testTarget(): void
    {
        $this->assertSame('<form method="POST" target="_blank">', Form::create()->target('_blank')->begin());
    }
}
