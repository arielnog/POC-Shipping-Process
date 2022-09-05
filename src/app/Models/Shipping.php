<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'shipping';

    /**
     * @var array|string[]
     */
    protected $fillable = [
        'from_postcode',
        'to_postcode',
        'from_weight',
        'to_weight',
        'cost',
        'file_control_id'
    ];

    /**
     * @var string[]
     */
    protected $guarded = [
        'id'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
