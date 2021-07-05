<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use InvalidArgumentException;
use Yii\Extension\Simple\Widget\AbstractWidget;
use Yiisoft\Html\Html;
use Yiisoft\Http\Method;

use function explode;
use function implode;
use function strpos;
use function substr;
use function urldecode;

/**
 *  Generates a form start tag.
 *
 *  @link https://www.w3.org/TR/html52/sec-forms.html
 */
final class Form extends AbstractWidget
{
    private string $action = '';
    private array $attributes = [];
    private ?string $id = null;
    private string $method = Method::POST;

    /**
     * @return string the generated form start tag.
     *
     * {@see end())}
     */
    public function begin(): string
    {
        parent::begin();

        $new = clone $this;

        $hiddenInputs = [];

        /** @var string */
        $new->attributes['id'] = isset($new->attributes['id']) ? $new->attributes['id'] : $new->id;

        /** @var string */
        $csrfToken = isset($new->attributes['_csrf']) ? $new->attributes['_csrf'] : '';

        if ($csrfToken !== '' && $new->method === Method::POST) {
            $hiddenInputs[] = Html::hiddenInput('_csrf', $csrfToken);
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

        if ($new->action !== '') {
            $new->attributes['action'] = $new->action;
        }

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

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-action
     *
     * @return static
     */
    public function action(string $value): self
    {
        $new = clone $this;
        $new->action = $value;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-accept-charset
     *
     * @return static
     */
    public function acceptCharset(string $value): self
    {
        $new = clone $this;
        $new->attributes['accept-charset'] = $value;
        return $new;
    }

    /**
     * The HTML attributes for the navbar. The following special options are recognized.
     *
     * @param array $value
     *
     * @return static
     */
    public function attributes(array $value): self
    {
        $new = clone $this;
        $new->attributes = $value;
        return $new;
    }

    /**
     * Specifies whether the element represents an input control for which a UA is meant to store the value entered by
     * the user (so that the UA can prefill the form later).
     *
     * @param string $value The value must be `on`,` off`.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-autocompleteelements-autocomplete
     */
    public function autocomplete(string $value = 'on'): self
    {
        if ($value !== 'on' && $value !== 'off') {
            throw new InvalidArgumentException('The value must be `on`,` off`.');
        }

        $new = clone $this;
        $new->attributes['autocomplete'] = $value;
        return $new;
    }

    public function csrf(string $value): self
    {
        $new = clone $this;
        $new->attributes['_csrf'] = $value;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-enctype
     *
     * @return static
     */
    public function enctype(string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    public function id(string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-method
     *
     * @return static
     */
    public function method(string $value): self
    {
        $new = clone $this;
        $new->method = strtoupper($value);
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-novalidate
     *
     * @return static
     */
    public function noValidateHtml(): self
    {
        $new = clone $this;
        $new->attributes['novalidate'] = true;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-target
     *
     * @return static
     */
    public function target(string $value = '_blank'): self
    {
        $new = clone $this;
        $new->attributes['target'] = $value;
        return $new;
    }
}
