# Date widget

[Date](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date) an input element for setting the element’s value to a string representing a date.

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

use Yii\Extension\Form\Date;
use Yii\Extension\Form\Field;
use Yii\Extension\Form\Form;
use Yii\Extension\Model\Contract\FormModelContract;

/**
 * @var FormModelContract $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Date::widget()->for($data, 'dateOfBirth') ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="-6rn3MlbGj1vvxDof0sbRjowkrdEAkIbjCzsLYUp77WU5pWe-wxdfBvWZ9oaeCwiWHHc3xJ1KS-7a9xB7ECl-Q==">
    <input type="hidden" name="_csrf" value="-6rn3MlbGj1vvxDof0sbRjowkrdEAkIbjCzsLYUp77WU5pWe-wxdfBvWZ9oaeCwiWHHc3xJ1KS-7a9xB7ECl-Q==">
    <input type="date" id="testform-dateofbirth" name="TestForm[dateOfBirth]">
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-88924893586001" class="button is-block is-info is-fullwidth" name="submit-88924893586001" value="Save">
    </div>
</form>
```

### `Date` methods: 

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
| `for(FormModelInterface $formModel, string $attribute)` | Configure the widget                   |         |
| `id(string $value)`                                     | Set the id attribute                   | `''`    |
| `name(string $value)`                                   | Set the name attribute.                | `''`    |
| `tabIndex(int $value)`                                  | Set the tabindex attribute             | `''`    |
| `title(string $value)`                                  | Set the title attribute                | `''`    |
| `value(string $value)`                                  | Set the value attribute                | `''`    |
