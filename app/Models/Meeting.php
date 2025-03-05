<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $created_by
 * @property int $organization_id
 * @property int $meeting_type_id
 * @property string $datetime
 * @property string $location
 * @property string|null $description
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\MeetingType $meetingType
 * @property-read \App\Models\Organization $organization
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meeting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meeting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meeting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meeting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meeting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meeting whereDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meeting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meeting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meeting whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meeting whereMeetingTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meeting whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meeting whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meeting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
