<?php

declare(strict_types=1);

use Composer\InstalledVersions;
use Yii\Extension\Simple\Forms\Field;

if (InstalledVersions::isInstalled('yii-extension/asset-bootstrap5')) {
    return [
        Field::class => Field::widget()
            ->ariaDescribedBy($params['yii-extension/simple-forms']['bootstrap5']['field-template']['ariaDescribedBy'])
            ->containerClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['containerClass'])
            ->errorClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['errorClass'])
            ->hintClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['hintClass'])
            ->inputClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['inputClass'])
            ->invalidClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['invalidClass'])
            ->labelClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['labelClass'])
            ->template($params['yii-extension/simple-forms']['bootstrap5']['field-template']['template'])
            ->validClass($params['yii-extension/simple-forms']['bootstrap5']['field-template']['validClass']),
    ];
}

if (InstalledVersions::isInstalled('yii-extension/asset-bulma')) {
    return [
        Field::class => Field::widget()
            ->containerClass($params['yii-extension/simple-forms']['bulma']['field-template']['containerClass'])
            ->errorClass($params['yii-extension/simple-forms']['bulma']['field-template']['errorClass'])
            ->hintClass($params['yii-extension/simple-forms']['bulma']['field-template']['hintClass'])
            ->inputClass($params['yii-extension/simple-forms']['bulma']['field-template']['inputClass'])
            ->invalidClass($params['yii-extension/simple-forms']['bulma']['field-template']['invalidClass'])
            ->labelClass($params['yii-extension/simple-forms']['bulma']['field-template']['labelClass'])
            ->template($params['yii-extension/simple-forms']['bulma']['field-template']['template'])
            ->validClass($params['yii-extension/simple-forms']['bulma']['field-template']['validClass']),
    ];
}

if (InstalledVersions::isInstalled('yii-extension/asset-tailwind')) {
    return [
        Field::class => Field::widget()
            ->containerClass($params['yii-extension/simple-forms']['tailwind']['field-template']['containerClass'])
            ->errorClass($params['yii-extension/simple-forms']['tailwind']['field-template']['errorClass'])
            ->hintClass($params['yii-extension/simple-forms']['tailwind']['field-template']['hintClass'])
            ->inputClass($params['yii-extension/simple-forms']['tailwind']['field-template']['inputClass'])
            ->invalidClass($params['yii-extension/simple-forms']['tailwind']['field-template']['invalidClass'])
            ->labelClass($params['yii-extension/simple-forms']['tailwind']['field-template']['labelClass'])
            ->template($params['yii-extension/simple-forms']['tailwind']['field-template']['template'])
            ->validClass($params['yii-extension/simple-forms']['tailwind']['field-template']['validClass']),
    ];
}
