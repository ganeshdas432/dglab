<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'doctor_name',
        'mobile',
        'appointment_date',
        'doctor_id',
        'status',
        'age',
        'address',
        'email',
        'notes'
    ];

    public function doctor()
{
    return $this->belongsTo(Doctor::class, 'doctor_id');
}
}
