<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{


    protected $fillable = ['title', 'text', 'user_id', 'created_at'];
    protected $primaryKey = 'id';
    protected $table = 'posts';

    public static function boot()
    {
        parent::boot();
        Post::observe(new \App\Observers\PostObserver);
    }
}
