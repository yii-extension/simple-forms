<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Attribute;

use InvalidArgumentException;
use Yii\Extension\Simple\Model\Helper\HtmlModel;
use Yii\Extension\Simple\Model\ModelInterface;
use Yiisoft\Html\Html;

trait ModelAttributes
{
    private array $attributes = [];
    private string $attribute = '';
    private string $charset = 'UTF-8';
    private string $id = '';
    private ?ModelInterface $model = null;

    /**
     * Set the character set used to generate the widget id. See {@see HtmlForm::getInputId()}.
     *
     * @param string $value
     *
     * @return static
     */
    public function charset(string $value): self
    {
        $new = clone $this;
        $new->charset = $value;
        return $new;
    }

    /**
     * Set form interface, attribute name and attributes, and attributes for the widget.
     *
     * @param ModelInterface $model Form.
     * @param string $attribute Form model property this widget is rendered for.
     * @param array $attributes The HTML attributes for the widget container tag.
     *
     * @return static
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function config(ModelInterface $model, string $attribute, array $attributes = []): self
    {
        $new = clone $this;
        $new->model = $model;
        $new->attribute = $attribute;
        $new->attributes = $attributes;
        return $new;
    }

    /**
     * Set the Id of the widget.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-id-attribute
     */
    public function id(string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    protected function getModel(): ModelInterface
    {
        if ($this->model === null) {
            throw new InvalidArgumentException('Form model is not set.');
        }

        return $this->model;
    }

    /**
     * Return the imput id.
     *
     * @return string
     */
    protected function getId(): string
    {
        $new = clone $this;

        /** @var string */
        $id = $new->attributes['id'] ?? $new->id;

        return $id === '' ? HtmlModel::getInputId($new->getModel(), $new->attribute, $new->charset) : $id;
    }
}
