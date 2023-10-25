<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jukir extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parkir()
    {
        return $this->hasMany(Parkir::class);
    }

    public function GajiBulanan()
    {
        return $this->hasMany(GajiBulanan::class);
    }
}
