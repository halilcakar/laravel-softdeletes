## Laravel SoftDeletes

**This just an extended SoftDeletes.php trait. You can just get and tweak however you want. Please examine the code before use,
there is nothing fuzy in this. I've just needed to do this and couldn't find a package for this so here it is :)**

Laravel version 5.0 and above. Get the SoftDeletes.php file and put it under `App\Traits\` folder on a laravel project.

Use this SoftDeletes instead of Laravels. 

When you put a date(Future date*) at `deleted_at` column, it will be deleted when the time comes.


* For example:
`Carbon\Carbon::now()->addHours(5);`


Usage::Example

Task.php:
```php
<?php

namespace App;

use App\Traits\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'body', 'ended'];

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name');
    }
}
```

And inside some controller you can do->

```php
Task::first()->deleteInFuture(Carbon\Carbon::now()->addHours(5));
```

