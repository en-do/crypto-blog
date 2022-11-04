<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PostTemplate extends Model
{
    use HasFactory, SoftDeletes;

    public function countVars() {
        $object = json_decode($this->vars);

        return count((array) $object);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getContent() {
        $vars = json_decode($this->vars);
        $content = $this->content;

        foreach ($vars as $var) {
            $replaced = Str::replace(":$var->code:", $var->value, $content);

            $content = $replaced;
        }

        return $content;
    }
}
