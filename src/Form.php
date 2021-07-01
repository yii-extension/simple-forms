<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yiisoft\Html\Html;
use Yiisoft\Http\Method;

use function explode;
use function implode;
use function strpos;
use function substr;
use function urldecode;

/**
 * A widget for rendering a form.
 */
final class Form extends Widget
{
    private string $action = '';
    private string $csrf = '';
    private string $method = Method::POST;

    /**
     * Generates a form start tag.
     *
     * @return string the generated form start tag.
     *
     * {@see end())}
     */
    public function begin(): string
    {
        parent::begin();

        $new = clone $this;

        $hiddenInputs = [];

        if (($id = $new->getId()) !== '') {
            $new->attributes['id'] = $id;
        }

        if ($new->csrf !== '' && $new->method === Method::POST) {
            $hiddenInputs[] = Html::hiddenInput('_csrf', $new->csrf);
        }

        if ($new->method === Method::GET && ($pos = strpos($new->action, '?')) !== false) {
            /**
             * Query parameters in the action are ignored for GET method we use hidden fields to add them back.
             */
            foreach (explode('&', substr($new->action, $pos + 1)) as $pair) {
                if (($pos1 = strpos($pair, '=')) !== false) {
                    $hiddenInputs[] = Html::hiddenInput(
                        urldecode(substr($pair, 0, $pos1)),
                        urldecode(substr($pair, $pos1 + 1))
                    );
                } else {
                    $hiddenInputs[] = Html::hiddenInput(urldecode($pair), '');
                }
            }

            $new->action = substr($new->action, 0, $pos);
        }

        $new->attributes['action'] = $new->action;
        $new->attributes['method'] = $new->method;

        $form = Html::openTag('form', $new->attributes);

        if (!empty($hiddenInputs)) {
            $form .= "\n" . implode("\n", $hiddenInputs);
        }

        return $form;
    }

    /**
     * Generates a form end tag.
     *
     * @return string the generated tag.
     *
     * {@see beginForm()}
     */
    protected function run(): string
    {
        return Html::closeTag('form');
    }

    public function action(string $value): self
    {
        $new = clone $this;
        $new->action = $value;
        return $new;
    }

    public function csrf(string $value): self
    {
        $new = clone $this;
        $new->csrf = $value;
        return $new;
    }

    public function method(string $value): self
    {
        $new = clone $this;
        $new->method = strtoupper($value);
        return $new;
    }

    public function noValidateHtml(): self
    {
        $new = clone $this;
        $new->attributes['novalidate'] = true;
        return $new;
    }
}
