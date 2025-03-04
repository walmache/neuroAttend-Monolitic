<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;



class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'identification',
        'email',
        'phone',
        'photo',
        'status',
        'created_by',
        'login',
        'password',
        'organization_id',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // public function organization()
    // {
    //     return $this->belongsTo(Organization::class, 'organization_id');
    // }

    // public function role()
    // {
    //     return $this->belongsTo(Role::class, 'role_id');
    // }

    // public function creator()
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }

    // Relación con la organización
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    // Relación con el rol
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Relación con las reuniones (como creador o asistente)
    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'created_by');
    }

    // Relación con las asistencias (como usuario que asiste a las reuniones)
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    // Relación con los registros de asistencia que el usuario ha creado
    public function createdAttendances()
    {
        return $this->hasMany(Attendance::class, 'created_by');
    }

    // Verificar si el usuario tiene un rol de Administrador
    public function isAdmin()
    {
        return $this->role->name === 'Administrator';
    }

    // Verificar si el usuario tiene un rol de Moderador
    public function isModerator()
    {
        return $this->role->name === 'Moderator';
    }

    // Verificar si el usuario tiene un rol de Usuario
    public function isUser()
    {
        return $this->role->name === 'User';
    }
}
