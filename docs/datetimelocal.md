# DateTimeLocal widget

[DateTimeLocal](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.datetime-local.html#input.datetime-local) is an input element representing a local date and time (with no timezone information).

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yii\Extension\Model\FormModel;

final class TestForm extends FormModel
{
    public string $dateOfBirth = '';
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yii\Extension\Form\DateTimeLocal;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Form;
use Yii\Extension\Model\Contract\FormModelContract;

/**
 * @var FormModelContract $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= DateTimeLocal::widget()->for($data, 'dateOfBirth') ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="obaov_DQ0lgetzPikYcaBpmAJbx9qHmjNAm5f7ftWFHR2cSJw4OEDljYYJSh4nhU6vJm1zX3FfV-Q9go84ATOw==">
    <input type="hidden" name="_csrf" value="obaov_DQ0lgetzPikYcaBpmAJbx9qHmjNAm5f7ftWFHR2cSJw4OEDljYYJSh4nhU6vJm1zX3FfV-Q9go84ATOw==">
    <input type="datetime-local" id="testform-dateofbirth" name="TestForm[dateOfBirth]">
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-12043601298001" class="button is-block is-info is-fullwidth" name="submit-12043601298001" value="Save">
    </div>
</form>
```

### `DateTimeLocal` methods: 

| Method                | Description                  | Default |
|-----------------------|------------------------------|---------|
| `max(?string $value)` | The latest acceptable date   | `''`    |
| `min(?string $value)` | The earliest acceptable date | `''`    |

### `Common` methods:

| Method                                                  | Description                            | Default |
|---------------------------------------------------------|----------------------------------------|---------|
| `autofocus(bool $value = true)`                         | Set the autofocus attribute            | `false` |
| `attributes(array $attributes = [])`                    | The HTML attributes for the widget     | `[]`    |
| `class(string $class)`                                  | The CSS class for the widget           | `''`    |
| `charset(string $value)`                                | Set the charset attribute              | `UTF-8` |
| `disabled(bool $value = true)`                          | Set the disabled attribute             | `false` |
| `encode(bool $value)`                                   | Whether content should be HTML-encoded | `true`  |
| `for(FormModelContract $formModel, string $attribute)` | Configure the widget                   |         |
| `id(string $value)`                                     | Set the id attribute                   | `''`    |
| `name(string $value)`                                   | Set the name attribute.                | `''`    |
| `tabIndex(int $value)`                                  | Set the tabindex attribute             | `''`    |
| `title(string $value)`                                  | Set the title attribute                | `''`    |
| `value(string $value)`                                  | Set the value attribute                | `''`    |
