<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AbstractModel.
 *
 * @method static Builder|AbstractModel newModelQuery()
 * @method static Builder|AbstractModel newQuery()
 * @method static Builder|AbstractModel query()
 * @mixin Eloquent
 */
class AbstractModel extends Model
{
    //Trait declarations
    use HasFactory;

    //constant declarations

    //property declarations
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /*
    |--------------------------------------------------------------------------
    | BOOT METHOD
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Model Accessors
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Model Mutators
    |--------------------------------------------------------------------------

    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */
}
