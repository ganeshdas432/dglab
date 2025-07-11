<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

     protected $fillable = [
    'name',
    'specialization',
    'available_on',
    'available_from',
    'available_to',
];

}
