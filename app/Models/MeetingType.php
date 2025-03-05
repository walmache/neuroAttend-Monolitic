<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $created_by
 * @property string $name
 * @property string|null $description
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Meeting> $meetings
 * @property-read int|null $meetings_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeetingType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeetingType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeetingType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeetingType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeetingType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeetingType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeetingType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeetingType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeetingType whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeetingType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
