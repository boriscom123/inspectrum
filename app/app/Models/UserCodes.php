<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $code
 */
class UserCodes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'code'];

    public $timestamps = true;
}
