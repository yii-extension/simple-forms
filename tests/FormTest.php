<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Form;
use Yii\Extension\Simple\Forms\Tests\TestSupport\Form\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class FormTest extends TestCase
{
    use TestTrait;

    public function testAcceptCharset(): void
    {
        $this->assertSame(
            '<form method="POST" accept-charset="UTF-8">',
            Form::widget()->acceptCharset('UTF-8')->begin(),
        );
    }

    public function testAutocomplete(): void
    {
        /** on value */
        $this->assertSame(
            '<form method="POST" autocomplete="on">',
            Form::widget()->autocomplete()->begin(),
        );
        /** off value */
        $this->assertSame(
            '<form method="POST" autocomplete="off">',
            Form::widget()->autocomplete('off')->begin(),
        );
    }

    public function testAutocompleteException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value must be `on`,` off`.');
        Form::widget()->autocomplete('exception')->begin();
    }

    public function testBegin(): void
    {
        $this->assertSame(
            '<form action="/test" method="POST">',
            Form::widget()->action('/test')->begin(),
        );
        $this->assertSame(
            '<form action="/example" method="GET">',
            Form::widget()->action('/example')->method('GET')->begin(),
        );
        $hiddens = [
            '<input type="hidden" name="id" value="1">',
            '<input type="hidden" name="title" value="&lt;">',
        ];
        $this->assertSame(
            '<form action="/example" method="GET">' . "\n" . implode("\n", $hiddens),
            Form::widget()->action('/example?id=1&title=%3C')->method('GET')->begin()
        );
        $this->assertStringMatchesFormat(
            '<form action="/foo" method="GET">%A<input type="hidden" name="p" value>',
            Form::widget()->action('/foo?p')->method('GET')->begin(),
        );
    }

    public function testBeginEmpty(): void
    {
        $this->assertSame('<form method="POST">', Form::widget()->begin());
    }

    public function testEnctype(): void
    {
        $this->assertSame(
            '<form id="multipart/form-data" method="POST">',
            Form::widget()->enctype('multipart/form-data')->begin(),
        );
    }

    /**
     * Data provider for {@see testBeginSimulateViaPost()}.
     *
     * @return array test data
     */
    public function dataProviderBeginViaPost(): array
    {
        return [
            ['<form action="/foo" method="GET">', 'GET',  ''],
            ['<form action="/foo" method="GET" _csrf="tokenCsrf">', 'GET',  'tokenCsrf'],
            ['<form action="/foo" method="POST">', 'POST', '_csrf' => ''],
            [
                '<form action="/foo" method="POST" _csrf="tokenCsrf">' . "\n" . '<input type="hidden" name="_csrf" value="tokenCsrf">',
                'POST',
                '_csrf' => 'tokenCsrf'
            ],
        ];
    }

    /**
     * @dataProvider dataProviderBeginViaPost
     *
     * @param string $expected
     * @param string $method
     * @param array $options
     */
    public function testBeginViaPost(string $expected, string $method, string $csrf): void
    {
        $this->assertSame(
            $expected,
            Form::widget()->action('/foo')->method($method)->csrf($csrf)->begin(),
        );
        $this->assertSame(
            $expected,
            Form::widget()->action('/foo')->attributes(['_csrf' => $csrf])->method($method)->begin(),
        );
    }

    public function testId(): void
    {
        $this->assertSame('<form id="form-id" method="POST">', Form::widget()->id('form-id')->begin());
        $this->assertSame(
            '<form id="form-id" method="POST">',
            Form::widget()->attributes(['id' => 'form-id'])->begin(),
        );
    }

    public function testEnd(): void
    {
        Form::widget()->begin();
        $this->assertSame('</form>', Form::end());
    }

    public function testMethod(): void
    {
        $this->assertSame('<form method="GET">', Form::widget()->method('get')->begin());
        $this->assertSame('<form method="POST">', Form::widget()->method('post')->begin());
    }

    public function testNoValidateHtml(): void
    {
        $this->assertSame('<form method="POST" novalidate>', Form::widget()->noValidateHtml()->begin());
    }

    public function testTarget(): void
    {
        $this->assertSame('<form method="POST" target="_blank">', Form::widget()->target()->begin());
    }
}
