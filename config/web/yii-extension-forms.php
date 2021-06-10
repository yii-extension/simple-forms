<?php

declare(strict_types=1);

use Yii\Extension\Simple\Forms\Field;

if ($params['yii-extension/simple-forms']['bootstrap5']['enabled'] === true) {
    return [
        Field::class => Field::widget()
            ->containerCssClass(
                $params['yii-extension/simple-forms']['bootstrap5']['field-template']['containerCssClass']
            )
            ->inputCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['inputCssClass'])
            ->hintCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['hintCssClass'])
            ->labelCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['labelCssClass'])
            ->template($params['yii-extension/simple-forms']['bootstrap5']['field-template']['template']),
    ];
}

if ($params['yii-extension/simple-forms']['tailwind']['enabled'] === true) {
    return [
        Field::class => Field::widget()
            ->containerCssClass(
                $params['yii-extension/simple-forms']['tailwind']['field-template']['containerCssClass']
            )
            ->inputCssClass($params['yii-extension/simple-forms']['tailwind']['field-template']['inputCssClass'])
            ->labelCssClass($params['yii-extension/simple-forms']['tailwind']['field-template']['labelCssClass'])
            ->nohint()
            ->template($params['yii-extension/simple-forms']['tailwind']['field-template']['template']),
    ];
}
