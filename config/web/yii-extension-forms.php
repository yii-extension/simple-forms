<?php

declare(strict_types=1);

use Composer\InstalledVersions;
use Yii\Extension\Simple\Forms\Field;

if (InstalledVersions::isInstalled('yii-extension/asset-bootstrap5')) {
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

if (InstalledVersions::isInstalled('yii-extension/asset-bulma')) {
    return [
        Field::class => Field::widget()
            ->containerCssClass(
                $params['yii-extension/simple-forms']['bulma']['field-template']['containerCssClass']
            )
            ->errorCssClass($params['yii-extension/simple-forms']['bulma']['field-template']['errorCssClass'])
            ->hintCssClass($params['yii-extension/simple-forms']['bulma']['field-template']['hintCssClass'])
            ->inputCssClass($params['yii-extension/simple-forms']['bulma']['field-template']['inputCssClass'])
            ->labelCssClass($params['yii-extension/simple-forms']['bulma']['field-template']['labelCssClass'])
            ->template($params['yii-extension/simple-forms']['bulma']['field-template']['template']),
    ];
}

if (InstalledVersions::isInstalled('yii-extension/asset-tailwind')) {
    return [
        Field::class => Field::widget()
            ->containerCssClass(
                $params['yii-extension/simple-forms']['tailwind']['field-template']['containerCssClass']
            )
            ->errorCssClass($params['yii-extension/simple-forms']['tailwind']['field-template']['errorCssClass'])
            ->hintCssClass($params['yii-extension/simple-forms']['tailwind']['field-template']['hintCssClass'])
            ->inputCssClass($params['yii-extension/simple-forms']['tailwind']['field-template']['inputCssClass'])
            ->labelCssClass($params['yii-extension/simple-forms']['tailwind']['field-template']['labelCssClass'])
            ->nohint()
            ->template($params['yii-extension/simple-forms']['tailwind']['field-template']['template']),
    ];
}
