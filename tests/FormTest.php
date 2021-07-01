<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Simple\Forms\Form;
use Yii\Extension\Simple\Forms\Tests\Stub\PersonalForm;
use Yii\Extension\Simple\Forms\Tests\TestSupport\TestTrait;

final class FormTest extends TestCase
{
    use TestTrait;

    public function testBegin(): void
    {
        $html = Form::widget()->action('/test')->begin();
        $this->assertEquals('<form action="/test" method="POST">', $html);

        $html = Form::widget()->action('/example')->method('GET')->begin();
        $this->assertEquals('<form action="/example" method="GET">', $html);

        $hiddens = [
            '<input type="hidden" name="id" value="1">',
            '<input type="hidden" name="title" value="&lt;">',
        ];
        $this->assertEquals(
            '<form action="/example" method="GET">' . "\n" . implode("\n", $hiddens),
            Form::widget()->action('/example?id=1&title=%3C')->method('GET')->begin()
        );

        $expected = '<form action="/foo" method="GET">%A<input type="hidden" name="p" value="">';
        $html = Form::widget()->action('/foo?p')->method('GET')->begin();
        $this->assertStringMatchesFormat($expected, $html);
    }

    public function testBeginEmpty(): void
    {
        $html = Form::widget()->begin();
        $this->assertEquals('<form action="" method="POST">', $html);
    }

    /**
     * Data provider for {@see testBeginSimulateViaPost()}.
     *
     * @return array test data
     */
    public function dataProviderBeginViaPost(): array
    {
        return [
            ['<form action="/foo" method="GET">', 'GET',  'tokenCsrf'],
            [
                '<form action="/foo" method="POST">' . "\n" . '<input type="hidden" name="_csrf" value="tokenCsrf">',
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
        $html = Form::widget()->action('/foo')->method($method)->csrf($csrf)->begin();
        $this->assertSame($expected, $html);
    }

    public function testEnd(): void
    {
        Form::widget()->begin();
        $this->assertEquals('</form>', Form::end());
    }

    public function testMethod(): void
    {
        $html = Form::widget()->method('get')->begin();
        $this->assertSame('<form action="" method="GET">', $html);

        $html = Form::widget()->method('post')->begin();
        $this->assertSame('<form action="" method="POST">', $html);
    }

    public function testNoValidateHtml(): void
    {
        $this->assertSame('<form action="" method="POST" novalidate>', Form::widget()->noValidateHtml()->begin());
    }
}
