<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property boolean $is_default
 * @property string $created_at
 * @property string $updated_at
 */
class Role extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'is_default', 'created_at', 'updated_at'];

    public $timestamps = true;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['options'];

    /**
     * Get the RoleOptions associated with the Role.
     */
    public function options(): HasOne
    {
        return $this->hasOne(RoleOptions::class, 'role_id');
    }
}
