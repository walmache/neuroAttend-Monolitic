<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
 * 
 * @property int $duration
 * @property bool $virtual
 * @property int $capacity
 * @property array $customFields
 * @property bool $remember
 * @property float $fee_amount
 * @property string $qr_code
 * 
 * @property string $created_at
 * @property string $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\MeetingType $meetingType
 * @property-read \App\Models\Organization $organization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MeetingDocument> $documents
 *
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
        'duration',
        'is_virtual',
        'capacity',
        'custom_fields',
        'remember',
        'fee_amount',
        'qr_code',
        'status',
        'created_by'
    ];

    protected $attributes = [
        'custom_fields' => '{}' // Valor predeterminado como JSON vacío
    ];

    public $timestamps = true;

    protected $dates = ['datetime', 'created_at', 'updated_at'];
    

    protected $casts = [
        'virtual' => 'boolean',
        'capacity' => 'integer',
        'custom_fields' => 'array',
        'remember' => 'boolean',
        'datetime' => 'datetime',
        'fee_amount' => 'decimal:2'
    ];
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (isset($model->datetime)) {
                // Asegúrate de convertir el valor de 'datetime' a un objeto Carbon
                $model->datetime = Carbon::parse($model->datetime);
            }
        });
    }

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

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'attendances')
            ->withPivot(['attended', 'signature', 'notes', 'status']);
    }

    // Para convertir minutos en formato legible (horas:minutos)
    public function getFormattedTimeAttribute()
    {
        $hours = floor($this->time / 60);
        $minutes = $this->time % 60;
        return sprintf('%d:%02d', $hours, $minutes);
    }
    
    // Accesorio para generar código QR si no existe
    public function generateQrCode()
    {
        if (empty($this->qr_code)) {
            // Genera un código único para esta reunión
            $uniqueCode = md5($this->id . '-' . $this->datetime . '-' . time());
            $this->qr_code = $uniqueCode;
            $this->save();
        }
        
        return $this->qr_code;
    }
    
}
