<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $fillable = ['user_id', 'subscribe_id'];
    protected $primaryKey = 'id';
    protected $table = 'subscribe';
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        Subscribe::observe(new \App\Observers\SubscribeObserver);
    }
}
