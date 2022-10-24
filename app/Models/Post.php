<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'image',
        'content',
        'view'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function domains() {
        return $this->belongsToMany(Domain::class, 'post_domains');
    }

    public function meta() {
        return $this->hasOne(Meta::class);
    }
}
