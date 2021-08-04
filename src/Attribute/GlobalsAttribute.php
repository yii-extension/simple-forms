<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Attribute;

use InvalidArgumentException;
use Yiisoft\Html\Html;

trait GlobalsAttribute
{
    protected array $attributes = [];
    private string $dir = '';

    /**
     * All HTML elements may have the accesskey content attribute set. The accesskey attribute's value is used by the
     * user agent as a guide for creating a keyboard shortcut that activates or focuses the element.
     *
     * @param string $accessKey The access key. If empty, it means no access key.
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/interaction.html#the-accesskey-attribute
     */
    public function accesskey(string $accessKey): self
    {
        $new = clone $this;
        $new->attributes['accesskey'] = $accessKey;
        return $new;
    }

    /**
     * The HTML attributes. The following special options are recognized.
     *
     * @param array $value
     *
     * @return static
     *
     * See {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $value): self
    {
        $new = clone $this;
        $new->attributes = $value;
        return $new;
    }

    /**
     * The class attributes may be specified on all HTML elements. When specified on HTML elements, the class attribute
     * must have a value that is a set of space-separated tokens representing the various classes that the element
     * belongs to.
     *
     * @param string $class The class name. It can be a space-separated list of class names.
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#classes
     */
    public function class(string $class): self
    {
        $new = clone $this;

        if ($class !== '') {
            Html::addCssClass($new->attributes, $class);
        }

        return $new;
    }

    /**
     * The dir attribute specifies the element's text directionality.
     *
     * @param string $dir The directionality of the element. The value must be either left-to-right (ltr),
     * right-to-left (rtl) or auto.
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-dir-attribute
     */
    public function dir(string $dir): self
    {
        $dir = mb_strtolower($dir);

        if ($dir !== 'ltr' && $dir !== 'rtl' && $dir !== 'auto') {
            throw new InvalidArgumentException('The dir attribute value must be either "ltr", "rtl" or "auto".');
        }

        $new = clone $this;
        $new->attributes['dir'] = $dir;
        return $new;
    }

    /**
     * The draggable attribute is used to specify whether an element should be draggable.
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/dnd.html#the-draggable-attribute
     */
    public function draggable(): self
    {
        $new = clone $this;
        $new->attributes['draggable'] = "true";
        return $new;
    }

    /**
     * It allows defining placeholder.
     *
     * @param string $value
     *
     * @return static
     */
    public function placeholder(string $value): self
    {
        $new = clone $this;
        $new->attributes['placeholder'] = $value;
        return $new;
    }

    /**
     * If it is required to fill in a value in order to submit the form.
     *
     * @return static
     *
     * @link https://www.w3.org/Submission/web-forms2/#required
     */
    public function required(): self
    {
        $new = clone $this;
        $new->attributes['required'] = true;
        return $new;
    }
}
