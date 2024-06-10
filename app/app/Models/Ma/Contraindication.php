<?php

namespace App\Models\Ma;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $number
 * @property string $name
 * @property string $full_name
 * @property integer $diagnose_id
 * @property string $diagnose_code
 * @property string $created_at
 * @property string $updated_at
 */
class Contraindication extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ma_contraindications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['number', 'name', 'full_name', 'diagnose_id', 'diagnose_code', 'created_at', 'updated_at'];

    public $timestamps = true;
}
