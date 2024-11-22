<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    // Permitimos la asignación masiva de estos campos
    protected $fillable = ['name', 'path'];
}
