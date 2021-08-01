<?php

declare(strict_types=1);

return [
    'yii-extension/simple-forms' => [
        'bootstrap5' => [
            'field-template' => [
                'ariaDescribedBy' => true,
                'containerCssClass' => 'form-floating',
                'errorCssClass' => 'invalid-feedback',
                'hintCssClass' => 'form-text',
                'inputCssClass' => 'form-control',
                'labelCssClass' => 'floatingInput',
                'invalidCssClass' => 'is-invalid',
                'template' => "{input}{label}{hint}{error}",
                'validCssClass' => 'is-valid',
            ],
        ],
        'bulma' => [
            'field-template' => [
                'containerCssClass' => 'field',
                'errorCssClass' => 'has-text-danger is-italic',
                'hintCssClass' => 'help',
                'inputCssClass' => 'input',
                'labelCssClass' => 'label',
                'template' => "{label}<div class=\"control\">\n{input}</div>\n{hint}\n{error}",
            ],
        ],
        'tailwind' => [
            'field-template' => [
                'containerCssClass' => 'mb-6',
                'errorCssClass' => 'text-red-600 italic',
                'hintCssClass' => 'font-semibold',
                'inputCssClass' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline',
                'labelCssClass' => 'block text-gray-700 text-sm font-bold mb-2',
                'template' => "{label}\n{input}\n{hint}\n{error}",
            ],
        ],
    ],
];
