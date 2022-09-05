<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clients';

    /**
     * @var array|string[]
     */
    protected $fillable = [
        'uuid',
        'name'
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

    /**
     * @return HasMany
     */
    public function file(): HasMany
    {
        return $this->hasMany(
            FileControl::class,
            'client_id',
            'id'
        );
    }

    /**
     * @return HasManyThrough
     */
    public function shipping(): HasManyThrough
    {
        return $this->hasManyThrough(
            Shipping::class,
            FileControl::class,
            'client_id',
            'file_control_id'
        );
    }
}
