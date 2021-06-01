<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms;

use Stringable;
use Yii\Extension\Simple\Model\ModelInterface;

interface FormModelInterface extends ModelInterface
{
    /**
     * Returns the value for the specified attribute.
     *
     * @param string $attribute
     *
     * @return Stringable|null|scalar
     */
    public function getAttributeValue(string $attribute);
}
