<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];
    
    protected $fillable = ['title', 'description', 'user_id'];
}
