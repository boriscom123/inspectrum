<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property boolean $is_active
 * @property string $title
 * @property string $poster
 * @property string $src
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 */
class Reviews extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reviews';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['is_active', 'title', 'poster', 'src', 'type', 'created_at', 'updated_at'];

    public $timestamps = true;
}
