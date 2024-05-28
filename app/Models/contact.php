<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    use HasFactory;

    protected $fillable = ["name", "phone", "group_id" , "order"];


    protected static function booted()
    {

        static::addGlobalScope('user', function ($builder) {
            $builder->where("user_id", auth()->id())->orderBy('order', 'asc');
        });

        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });
    }
}
