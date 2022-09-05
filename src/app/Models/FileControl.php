<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileControl extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'file_control';

    /**
     * @var array|string[]
     */
    protected $fillable = [
        'uuid',
        'file_name',
        'path',
        'status',
        'client_id',
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
