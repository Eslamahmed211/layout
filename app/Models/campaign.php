<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class campaign extends Model
{
    use HasFactory;

    protected $fillable = ["name", "status", "form", "to", "started_at", "ended_at", "device_id", "message_id", "user_id"];

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
