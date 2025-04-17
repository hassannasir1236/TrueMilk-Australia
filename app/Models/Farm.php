<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\User;
class Farm extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'phone',
        'description',
        'state_id',
        'user_id',
        'email',
        'website',
        'farm_size',
        'is_active',
        'latitude',
        'longitude',
    ];

    /** Farm belongs to a State */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /** Farm may belong to a User (owner) */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
