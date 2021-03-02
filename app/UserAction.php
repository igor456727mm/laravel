<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAction extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'user_action';
    protected $fillable = ['user_id', 'action', 'action_model', 'action_id'];
}
