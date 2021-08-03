<?php

declare(strict_types=1);

return [
    'yii-extension/simple-forms' => [
        'bootstrap5' => [
            'field-template' => [
                'ariaDescribedBy' => true,
                'containerClass' => 'form-floating',
                'errorClass' => 'invalid-feedback',
                'hintClass' => 'form-text',
                'inputClass' => 'form-control',
                'labelClass' => 'floatingInput',
                'invalidClass' => 'is-invalid',
                'template' => "{input}{label}{hint}{error}",
                'validClass' => 'is-valid',
            ],
        ],
        'bulma' => [
            'field-template' => [
                'containerClass' => 'field',
                'errorClass' => 'has-text-danger is-italic',
                'hintClass' => 'help',
                'inputClass' => 'input',
                'invalidClass' => 'has-background-danger',
                'labelClass' => 'label',
                'template' => "{label}<div class=\"control\">\n{input}</div>\n{hint}\n{error}",
                'validClass' => 'has-background-success',
            ],
        ],
        'tailwind' => [
            'field-template' => [
                'containerClass' => 'mb-6',
                'errorClass' => 'text-red-600 italic',
                'hintClass' => 'font-semibold',
                'inputClass' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline',
                'invalidClass' => 'border-red-600',
                'labelClass' => 'block text-gray-700 text-sm font-bold mb-2',
                'template' => "{label}\n{input}\n{hint}\n{error}",
                'validClass' => 'border-green-600',
            ],
        ],
    ],
];
