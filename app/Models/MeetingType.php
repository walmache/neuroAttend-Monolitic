<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingType extends Model
{
    use HasFactory;

    protected $table = 'meeting_types';

    protected $fillable = [
        'name',
        'description',
        'status',
        'created_at',
        'updated_at',
        'created_by'
    ];

    public $timestamps = false;

    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'meeting_type_id');
    }
}
