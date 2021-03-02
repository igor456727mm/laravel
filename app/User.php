<?php

namespace App;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    protected $fillable = ['name'];
    protected $primaryKey = 'id';
    protected $table = 'users';
    public $timestamps = false;
    public static function boot()
    {
        parent::boot();
        User::observe(new \App\Observers\UserObserver);
    }
}
