<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $table = 'meetings';

    protected $fillable = [
        'organization_id',
        'meeting_type_id',
        'datetime',
        'location',
        'description',
        'status',
        'created_at',
        'updated_at',
        'created_by'
    ];

    public $timestamps = false;

    protected $dates = ['datetime'];

    // Relación con la organización
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    // Relación con el tipo de reunión
    public function meetingType()
    {
        return $this->belongsTo(MeetingType::class, 'meeting_type_id');
    }

    // Relación con el usuario que creó la reunión
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'meeting_id');
    }

}
