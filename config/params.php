<?php

declare(strict_types=1);

return [
    'yii-extension/simple-forms' => [
        'bootstrap5' => [
            'enabled' => true,
            'field-template' => [
                'ariaDescribedBy' => true,
                'containerCssClass' => 'mt-3',
                'errorCssClass' => 'invalid-feedback',
                'hintCssClass' => 'form-text',
                'inputCssClass' => 'form-control',
                'labelCssClass' => 'form-label text-start',
                'template' => "{label}{input}{hint}{error}",
            ],
        ],
        'bulma' => [
            'enabled' => false,
            'field-template' => [
                'containerCssClass' => 'field',
                'hintCssClass' => 'help',
                'inputCssClass' => 'input',
                'labelCssClass' => 'label',
                'template' => "{label}<div class=\"control\">\n{input}</div>\n{hint}",
            ],
        ],
        'tailwind' => [
            'enabled' => false,
            'field-template' => [
                'containerCssClass' => 'grid grid-cols-1 gap-6',
                'inputCssClass' => 'mt-1 block w-full',
                'labelCssClass' => 'text-gray-700',
                'template' => "<div class=\"block\">\n{label}{input}</div>\n",
            ],
        ],
    ],
];
