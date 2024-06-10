<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $number
 * @property string $name
 * @property string $description
 * @property integer $parent_id
 */
class OrderPoint extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_points';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['number', 'name', 'description', 'parent_id'];

    public $timestamps = false;
}
