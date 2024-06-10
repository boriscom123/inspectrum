<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $slug
 * @property boolean $is_active
 * @property string $title
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 */
class Page extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'is_active', 'title', 'text', 'created_at' , 'updated_at'];

    public $timestamps = true;
}
