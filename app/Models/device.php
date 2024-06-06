<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class device extends Model
{
    use HasFactory;


    protected $fillable = ["name", "token", "user_id"];

    protected static function booted()
    {
        static::addGlobalScope('user', function ($builder) {
            $builder->where("user_id", auth()->id());
        });

        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });
    }
}
