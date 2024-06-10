<?php

namespace App\Models\Ma;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $full_name
 * @property string $created_at
 * @property string $updated_at
 */
class Diagnose extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ma_diagnoses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'name', 'full_name', 'created_at', 'updated_at'];

    public $timestamps = true;
}
