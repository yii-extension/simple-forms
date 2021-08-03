<?php

declare(strict_types=1);

use Composer\InstalledVersions;
use Yii\Extension\Simple\Forms\Field;

if (InstalledVersions::isInstalled('yii-extension/asset-bootstrap5')) {
    return [
        Field::class => Field::widget()
            ->ariaDescribedBy($params['yii-extension/simple-forms']['bootstrap5']['field-template']['ariaDescribedBy'])
            ->containerCssClass(
                $params['yii-extension/simple-forms']['bootstrap5']['field-template']['containerClass']
            )
            ->errorCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['errorClass'])
            ->hintCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['hintClass'])
            ->inputCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['inputClass'])
            ->invalidCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['invalidClass'])
            ->labelCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['labelClass'])
            ->template($params['yii-extension/simple-forms']['bootstrap5']['field-template']['template'])
            ->validCssClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['validClass']),
    ];
}

if (InstalledVersions::isInstalled('yii-extension/asset-bulma')) {
    return [
        Field::class => Field::widget()
            ->containerCssClass(
                $params['yii-extension/simple-forms']['bulma']['field-template']['containerClass']
            )
            ->errorCssClass($params['yii-extension/simple-forms']['bulma']['field-template']['errorClass'])
            ->hintCssClass($params['yii-extension/simple-forms']['bulma']['field-template']['hintClass'])
            ->inputCssClass($params['yii-extension/simple-forms']['bulma']['field-template']['inputClass'])
            ->invalidCssClass($params['yii-extension/simple-forms']['bulma']['field-template']['invalidClass'])
            ->labelCssClass($params['yii-extension/simple-forms']['bulma']['field-template']['labelClass'])
            ->template($params['yii-extension/simple-forms']['bulma']['field-template']['template'])
            ->validCssClass($params['yii-extension/simple-forms']['bulma']['field-template']['validClass']),
    ];
}

if (InstalledVersions::isInstalled('yii-extension/asset-tailwind')) {
    return [
        Field::class => Field::widget()
            ->containerCssClass(
                $params['yii-extension/simple-forms']['tailwind']['field-template']['containerClass']
            )
            ->errorCssClass($params['yii-extension/simple-forms']['tailwind']['field-template']['errorClass'])
            ->hintCssClass($params['yii-extension/simple-forms']['tailwind']['field-template']['hintClass'])
            ->inputCssClass($params['yii-extension/simple-forms']['tailwind']['field-template']['inputClass'])
            ->invalidCssClass($params['yii-extension/simple-forms']['tailwind']['field-template']['invalidClass'])
            ->labelCssClass($params['yii-extension/simple-forms']['tailwind']['field-template']['labelClass'])
            ->template($params['yii-extension/simple-forms']['tailwind']['field-template']['template'])
            ->validCssClass($params['yii-extension/simple-forms']['tailwind']['field-template']['validClass']),
    ];
}
