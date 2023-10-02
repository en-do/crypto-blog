<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

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

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){

            if(Post::where('slug', $model->slug)->exists()) {
                $time = time();

                $model->slug = "$model->slug-$time";
            }
        });
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function domains() {
        return $this->belongsToMany(Domain::class, 'post_domains');
    }

    public function meta() {
        return $this->hasOne(Meta::class);
    }

    public function checkedDomain($domain_id) {
        return $this->domains()->where('domain_id', $domain_id)->exists();
    }

    public function seoRate() {
        if($this->meta->no_index) {
            return 'rounded-circle bg-danger';
        }

        if($this->status == 'published') {
            if($this->meta->title && $this->meta->description) {
                if(strlen($this->meta->description) > 80) {
                    return 'rounded-circle bg-success';
                }

                return 'rounded-circle bg-warning';
            }

            return 'rounded-circle bg-secondary';
        }

        return 'rounded-circle bg-danger';
    }
}
