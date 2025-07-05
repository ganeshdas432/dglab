<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
    'receipt_id',
    'patient_name',
    'bill_date',
    'appointment_id',
    'file_path',
    'downloaded_at',
];

    public function appointment()
{
    return $this->belongsTo(Appointment::class, 'appointment_id');
}
}
