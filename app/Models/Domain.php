<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'expired_at'
    ];

    use HasFactory;

    public function posts() {
        return $this->belongsToMany(Post::class, 'post_domains');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'permission_users');
    }

    public function meta() {
        return $this->hasOne(Meta::class);
    }
}
