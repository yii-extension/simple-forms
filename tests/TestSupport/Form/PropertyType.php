<?php

declare(strict_types=1);

namespace Yii\Extension\Form\Tests\TestSupport\Form;

use Yii\Extension\Model\FormModel;

/**
 * @link https://www.php.net/manual/es/language.types.declarations.php
 */
final class PropertyType extends FormModel
{
    private ?array $array = [];
    private bool $bool = false;
    private float $float = 0;
    private int $int = 0;
    private iterable $iterable = [];
    private mixed $nullable = null;
    private ?int $number = null;
    private ?object $object = null;
    private string $string = '';
}
