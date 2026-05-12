<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdScheduling extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_year',
        'student_no',
        'guardian_name',
        'guardian_contact_no',
        'picture_id',
        'e_signature',
        'status',
        'pick_up_date',
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }
}
