<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    use HasFactory;

    protected $fillable = ["name", "user_id"];

    protected static function booted()
    {
        static::addGlobalScope('user', function ($builder) {
            $builder->where("user_id", auth()->id());
        });

        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });
    }

    public function contacts()
    {
        return $this->hasMany(contact::class, 'group_id');
    }
}
