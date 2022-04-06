# RadioList widget

[RadioList] Generates a list of radio buttons with a single selection.

## Usage

You can configure the widget to return the index of the checked item.

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yii\Extension\Model\FormModel;

final class TestForm extends FormModel
{
    public ?bool $status = null;
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yii\Extension\Form\Form;
use Yii\Extension\Form\RadioList;
use Yii\Extension\Form\SubmitButton;
use Yii\Extension\Model\Contract\FormModelContract;

/**
 * @var FormModelContract $data
 * @var string $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= RadioList::widget()->for($data, 'status')->items(['0' => 'Inactive', '1' => 'Active']) ?>
    <hr class="mt-3">
    <?= SubmitButton::widget()->class('button is-block is-info is-fullwidth')->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```HTML
<form action="widgets" method="POST" _csrf="B7JDqk23RQz-iaCopesFk8q42ckOCtOrtpgPJKYb8Y5fxjHCe9o_SLfC_5vKtDD5qPmagjhD4eP9ymJ310SQvg==">
    <input type="hidden" name="_csrf" value="B7JDqk23RQz-iaCopesFk8q42ckOCtOrtpgPJKYb8Y5fxjHCe9o_SLfC_5vKtDD5qPmagjhD4eP9ymJ310SQvg==">
    <div id="testform-status">
        <label><input type="radio" name="TestForm[status]" value="0"> Inactive</label>
        <label><input type="radio" name="TestForm[status]" value="1"> Active</label>
    </div>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-88909001741001" class="button is-block is-info is-fullwidth" name="submit-88909001741001" value="Save">
    </div>
</form>
```

### Custom values 

Custom values could be set as well. In this example we use two values for selection states (`Inactive`, `Active`), and `Undefined` when the radio is not selected.

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yii\Extension\Model\FormModel;

final class TestForm extends FormModel
{
    public ?string $status = '';
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yii\Extension\Form\Form;
use Yii\Extension\Form\RadioList;
use Yii\Extension\Form\SubmitButton;
use Yii\Extension\Model\Contract\FormModelContract;

/**
 * @var FormModelContract $data
 * @var string $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= RadioList::widget()->for($data, 'status')->itemsFromValues(['0' => 'Inactive', '1' => 'Active'])->uncheckValue('Undefined') ?>
    <hr class="mt-3">
    <?= SubmitButton::widget()->class('button is-block is-info is-fullwidth')->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```HTML
<form action="widgets" method="POST" _csrf="ja13mmBm3yP15IY16C77EYAJubug3MXnmMv_QcKYl2DV2QXyVgulZ7yv2QaHcc574kj68JaV96_TmZISs8f2UA==">
    <input type="hidden" name="_csrf" value="ja13mmBm3yP15IY16C77EYAJubug3MXnmMv_QcKYl2DV2QXyVgulZ7yv2QaHcc574kj68JaV96_TmZISs8f2UA==">
    <input type="hidden" name="TestForm[status]" value="Undefined">
    <div id="testform-status">
        <label><input type="radio" name="TestForm[status]" value="Inactive"> Inactive</label>
        <label><input type="radio" name="TestForm[status]" value="Active"> Active</label>
    </div>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-195984777722001" class="button is-block is-info is-fullwidth" name="submit-195984777722001" value="Save">
    </div>
</form>
```

### `RadioList` methods: 

| Method                                              | Description                                       | Default  |
|-----------------------------------------------------|---------------------------------------------------|----------|
| `autofocus(bool $value = true)`                     | Set the autofocus widget                          | `false`  |
| `containerAttributes(array $attributes)`            | HTML attributes for a container tag               | `[]`     |
| `containerTag(?string $name = null)`                | Tag name of the container element                 | `div`    |
| `id(?string $id = null)`                            | Set the ID of container the widget                | `null`   |
| `individualItemsAttributes(array $attributes = [])` | HTML attributes for individual checkbox elements. | `[]`     |
| `items(array $items = [])`                          | A list of checkbox items for array keys.          | `[]`     |
| `itemsAttributes(array $attributes = [])`           | HTML attributes for checkbox elements.            | `[]`     |
| `itemsFormatter(?Closure $formatter)`               | Formatter for checkbox items.                     | `null`   |
| `itemsFromValues(array $values = [])`               | List of checkbox items for array values.          | `[]`     |
| `separator(string $separator)`                      | HTML to insert between each checkbox element.     | `&nbsp;` |
| `uncheckValue($value):`                             | A value for uncheck option.                       | `null`   |
| `tabIndex(int $value)`                              | Set the tabindex attribute                        | `''`     |

### `Common` methods:

| Method                                                  | Description                                                      | Default |
|---------------------------------------------------------|------------------------------------------------------------------|---------|
| `attributes(array $attributes = [])`                    | The HTML attributes for the widget                               | `[]`    |
| `charset(string $value)`                                | Sets the charset attribute                                       | `UTF-8` |
| `disabled()`                                            | Set whether the element is disabled or not                       | `false` |
| `encode(bool $value)`                                   | Whether content should be HTML-encoded                           | `true`  |
| `for(FormModelContract $formModel, string $attribute)` | Configure the widget                                             |         |
| `name(string $value)`                                   | Set the name attribute                                           | `''`    |
| `value($value)`                                         | The value content attribute gives the default value of the field | `''`    |
