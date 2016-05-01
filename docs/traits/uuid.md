# UUID Trait

This trait is for use on Eloquent Models that instead of auto-incrementing they will have UUID's generated for their IDs.

## Usage

### Database Migration

If you wish to use a UUID as the primary ID on a model, you will need to update the model's migration file to remove `$table->increments('id');` and replace it with `$table->uuid('id')`.

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
	/**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->uuid('id');
		});
	}
}
```

### Model

```php
<?php

namespace App\Models;

use IanOlson\Support\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	use UuidTrait;
	
	/**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
```