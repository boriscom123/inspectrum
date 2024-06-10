<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $role_id
 * @property boolean $is_access_admin_part
 * @property string $created_at
 * @property string $updated_at
 */
class RoleOptions extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id', 'is_access_admin_part', 'created_at', 'updated_at'];

    public $timestamps = true;
}
