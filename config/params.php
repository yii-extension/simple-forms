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
                'containerCssClass' => 'grid grid-cols-1 gap-6',
                'inputCssClass' => 'mt-1 block w-full',
                'labelCssClass' => 'text-gray-700',
                'template' => "<div class=\"block\">\n{label}{input}</div>\n",
            ],
        ],
    ],
];
