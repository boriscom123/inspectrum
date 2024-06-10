<?php

namespace App\Models\Ma;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $order_point_id
 * @property string $order_point_number
 * @property integer $contraindication_id
 * @property string $contraindication_number
 * @property string $created_at
 * @property string $updated_at
 */
class ContraindicationOrderPoint extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ma_contraindications_order_points';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_point_id', 'order_point_number', 'contraindication_id', 'contraindication_number', 'created_at', 'updated_at'];

    public $timestamps = true;
}
