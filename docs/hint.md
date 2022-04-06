# Hint widget

Displays hint for a field form.

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yii\Extension\Model\FormModel;

final class TestForm extends FormModel
{
    private string $name = '';

    public function getAttributeHints(): array
    {
        return [
            'name' => 'Write your first name.',
        ];
    }    
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yii\Extension\Form\Form;
use Yii\Extension\Form\Part\Hint;
use Yii\Extension\Form\SubmitButton;
use Yii\Extension\Form\Text;
use Yii\Extension\Model\Contract\FormModelContract;

/**
 * @var FormModelContract $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Text::widget()->for($formModel, 'name') ?>
    <?= Hint::widget()->for($formModel, 'name') ?>
    <hr class="mt-3">
    <?= SubmitButton::widget()->class('button is-block is-info is-fullwidth')->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="BJKr0W43OfWETd0B8fZbrZFOKGzxkdoOZRRcuh4B1Gk3pdK_C2N6xfMbhXiQrjr153kZFrLLtXojcw6OV0CeAg==">
    <input type="hidden" name="_csrf" value="BJKr0W43OfWETd0B8fZbrZFOKGzxkdoOZRRcuh4B1Gk3pdK_C2N6xfMbhXiQrjr153kZFrLLtXojcw6OV0CeAg==">
    <input type="text" id="testform-name" name="TestForm[name]">
    <div>Write your first name.</div>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-74174218703001" class="button is-block is-info is-fullwidth" name="submit-74174218703001" value="Save">
    </div>
</form>
```

### Custom hint text

You can use custom hint text when calling the widget: 

```php
<?php

declare(strict_types=1);

use Yii\Extension\Form\Form;
use Yii\Extension\Form\Part\Hint;
use Yii\Extension\Form\SubmitButton;
use Yii\Extension\Form\Text;
use Yii\Extension\Model\Contract\FormModelContract;

/**
 * @var FormModelContract $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Text::widget()->for($formModel, 'name') ?>
    <?= Hint::widget()->for($formModel, 'name')->hint('Custom hint text.') ?>
    <hr class="mt-3">
    <?= SubmitButton::widget()->class('button is-block is-info is-fullwidth')->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="BJKr0W43OfWETd0B8fZbrZFOKGzxkdoOZRRcuh4B1Gk3pdK_C2N6xfMbhXiQrjr153kZFrLLtXojcw6OV0CeAg==">
    <input type="hidden" name="_csrf" value="BJKr0W43OfWETd0B8fZbrZFOKGzxkdoOZRRcuh4B1Gk3pdK_C2N6xfMbhXiQrjr153kZFrLLtXojcw6OV0CeAg==">
    <input type="text" id="testform-name" name="TestForm[name]">
    <div>Write your first name.</div>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-74174218703001" class="button is-block is-info is-fullwidth" name="submit-74174218703001" value="Save">
    </div>
</form>
```

### `Hint` methods:

| Method                                                  | Description                         | Default |
|---------------------------------------------------------|-------------------------------------|---------|
| `attributes(array $attributes = [])`                    | The HTML attributes for the widget  | `[]`    |
| `encode(bool $value)`                                   | Whether to encode the error message | `true`  |
| `for(FormModelContract $formModel, string $attribute)` | Configure the widget                |         |
| `id(string $value)`                                     | Set the id attribute                | `''`    |
| `hint(?string $value)`                                  | Set the hint text                   | `''`    |
| `tag(string $value)`                                    | Set the tag name                    | `'div'` |
