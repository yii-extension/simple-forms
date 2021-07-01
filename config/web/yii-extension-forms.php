<?php

declare(strict_types=1);

use Yii\Extension\Simple\Forms\Field;

if ($params['yii-extension/simple-forms']['bootstrap5']['enabled'] === true) {
    return [
        Field::class => Field::widget()
            ->ariaDescribedBy($params['yii-extension/simple-forms']['bootstrap5']['field-template']['ariaDescribedBy'])
            ->containerCssClass(
                $params['yii-extension/simple-forms']['bootstrap5']['field-template']['containerCssClass']
            )
            ->errorCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['errorCssClass'])
            ->hintCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['hintCssClass'])
            ->inputCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['inputCssClass'])
            ->invalidCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['invalidCssClass'])
            ->labelCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['labelCssClass'])
            ->template($params['yii-extension/simple-forms']['bootstrap5']['field-template']['template'])
            ->validCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['validCssClass']),
    ];
}

if ($params['yii-extension/simple-forms']['bulma']['enabled'] === true) {
    return [
        Field::class => Field::widget()
            ->containerCssClass(
                $params['yii-extension/simple-forms']['bulma']['field-template']['containerCssClass']
            )
            ->hintCssClass($params['yii-extension/simple-forms']['bulma']['field-template']['hintCssClass'])
            ->inputCssClass($params['yii-extension/simple-forms']['bulma']['field-template']['inputCssClass'])
            ->labelCssClass($params['yii-extension/simple-forms']['bulma']['field-template']['labelCssClass'])
            ->template($params['yii-extension/simple-forms']['bulma']['field-template']['template']),
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
