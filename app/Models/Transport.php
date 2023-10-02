<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function parkir()
    {
        return $this->hasMany(Parkir::class);
    }
}
