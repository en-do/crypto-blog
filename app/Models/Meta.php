<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'no_index',
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function domain() {
        return $this->belongsTo(Domain::class);
    }
}
