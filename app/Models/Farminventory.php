<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farminventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'state_id', 'farm_id', 'farm_item_id', 'quantity', 'unit', 'notes', 'collected_on','total_price'
    ];

    public function farm() {
        return $this->belongsTo(Farm::class);
    }

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function item() {
        return $this->belongsTo(FarmItem::class, 'farm_item_id');
    }
}
