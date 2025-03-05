<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\MeetingTypeController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Record\AttendanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación (login, registro, etc.)
Auth::routes();

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requieren Autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    /*
    |--------------------------------------------------------------------------
    | Administración (Admin)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {

        // 🔹 SuperAdministradores tienen acceso a TODO
        Route::middleware(['role:SuperAdministrador'])->group(function () {
            Route::resource('organizations', OrganizationController::class);
            Route::resource('users', UserController::class);
        });

        // 🔹 Administradores pueden gestionar solo Tipos de Reunión y Reuniones
        Route::middleware(['role:Administrador|SuperAdministrador'])->group(function () {
            Route::resource('meeting-types', MeetingTypeController::class);
            Route::resource('meetings', MeetingController::class);
        });

        // 🔹 Coordinadores pueden acceder solo a Reuniones
        Route::middleware(['role:Coordinador|Administrador|SuperAdministrador'])->group(function () {
            Route::get('meetings', [MeetingController::class, 'index'])->name('meetings.index');
        });

        // 🔹 Ruta para cambio de contraseña (Solo Administradores y SuperAdministradores)
        Route::get('users/{user}/change-password', [UserController::class, 'showChangePasswordForm'])
            ->name('users.change-password')
            ->middleware('permission:editar usuarios');

        Route::post('users/{user}/change-password', [UserController::class, 'updatePassword'])
            ->name('users.update-password')
            ->middleware('permission:editar usuarios');

        // 🔹 Historial de reuniones del usuario (Solo SuperAdmin y Administradores)
        Route::get('users/{user}/meetings-history', [UserController::class, 'meetingsHistory'])
            ->name('users.meetings-history')
            ->middleware('permission:ver reuniones');
    });

    /*
    |--------------------------------------------------------------------------
    | Registro de Asistencia (Record)
    |--------------------------------------------------------------------------
    */
    Route::prefix('record')->name('record.')->middleware(['role:Usuario|Coordinador|Administrador|SuperAdministrador'])->group(function () {

        // 🔹 Usuarios pueden acceder solo a la firma de asistencia
        Route::get('attendance', [AttendanceController::class, 'index'])
            ->name('attendance.index')
            ->middleware('permission:ver asistencias');

        Route::post('attendance/store', [AttendanceController::class, 'store'])
            ->name('attendance.store')
            ->middleware('permission:registrar asistencia');
    });

    /*
    |--------------------------------------------------------------------------
    | Reportes
    |--------------------------------------------------------------------------
    */
    Route::get('reports', [ReportController::class, 'index'])
        ->name('reports.index')
        ->middleware('permission:ver reportes');

});

/*
|--------------------------------------------------------------------------
| Keep-Alive (Evitar Cierre de Sesión)
|--------------------------------------------------------------------------
*/
Route::get('/keep-alive', function () {
    return response()->json(['status' => 'ok']);
})->name('keep-alive');
