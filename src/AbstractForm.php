<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Yiisoft\Widget\Widget;
use Yii\Extension\Simple\Model\Helper\HtmlForm;

abstract class AbstractForm extends Widget
{
    protected array $attributes = [];
    protected bool $encode = false;

    /**
     * The HTML attributes. The following special options are recognized.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = $values;
        return $new;
    }

    /**
     * Whether content should be HTML-encoded.
     *
     * @param bool $value
     *
     * @return static
     */
    public function encode(bool $value): self
    {
        $new = clone $this;
        $new->encode = $value;
        return $new;
    }

    /**
     * The id content attribute is a unique identifier for the element.
     *
     * @param string $value the id attribute value.
     *
     * @return static
     */
    public function id(string $value): self
    {
        $new = clone $this;
        $new->attributes['id'] = $value;
        return $new;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getEncode(): bool
    {
        return $this->encode;
    }
}
