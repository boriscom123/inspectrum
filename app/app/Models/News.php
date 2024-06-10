<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $slug
 * @property boolean $is_active
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $date_start
 * @property string $date_end
 * @property string $created_at
 * @property string $updated_at
 */
class News extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'is_active', 'title', 'description', 'text', 'date_start', 'date_end', 'created_at', 'updated_at'];

    public $timestamps = true;
}
