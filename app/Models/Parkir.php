<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parkir extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function jukir()
    {
        return $this->belongsTo(Jukir::class);
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }
}
