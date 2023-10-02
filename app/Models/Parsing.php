<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parsing extends Model
{
    use HasFactory;

    protected $dates = [
        'from_at',
        'to_at'
    ];

    public function domain() {
        return $this->belongsTo(Domain::class);
    }
}
