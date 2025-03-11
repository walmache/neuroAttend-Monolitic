<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\Admin\MeetingTypeController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/
Route::get('/', function () {  return view('welcome'); });

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

        // Gestión de Organizaciones y Usuarios
        Route::resource('organizations', OrganizationController::class);
        Route::resource('users', UserController::class);

        // Gestión de reuniones y tipos de reuniones
        Route::resource('meeting-types', MeetingTypeController::class);
        Route::resource('meetings', MeetingController::class);

        // Reportes
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

        // Rutas anidadas: Usuarios dentro de una organización
        // Route::get('/organizations/{organization}/users', [UserController::class, 'index'])->name('organizations.users.index');
        // Route::get('organizations/{organization}/users/create', [UserController::class, 'create'])->name('organizations.users.create');
        Route::prefix('organizations/{organization}')->group(function () {
            Route::resource('users', UserController::class)->names('organizations.users');
        });

        Route::prefix('meeting-types/{meetingType}')->group(function () {
            Route::resource('meetings', MeetingController::class)->names('meeting-types.meetings');
        });

        Route::prefix('meetings/{meeting}/attendances')->group(function () {
            Route::get('/', [AttendanceController::class, 'index'])->name('meetings.attendances.index');
            Route::post('/{user}', [AttendanceController::class, 'store'])->name('meetings.attendances.store');
            Route::patch('/{attendance}', [AttendanceController::class, 'update'])->name('meetings.attendances.update');
            Route::delete('/{attendance}', [AttendanceController::class, 'destroy'])->name('meetings.attendances.destroy');
        });



        
        // 🔹 Historial de reuniones del usuario (Solo SuperAdmin y Administradores)
        Route::get('users/{user}/meetings-history', [UserController::class, 'meetingsHistory'])
            //->middleware('permission:ver reuniones')
            ->name('users.meetings-history');
            
    });

    /*
    |--------------------------------------------------------------------------
    | Registro de Asistencia (Usuarios)
    |--------------------------------------------------------------------------
    */
    Route::prefix('record')->name('record.')->group(function () {
        Route::post('/attendance/store', [AttendanceController::class, 'storeSelfAttendance'])
            ->name('attendance.store-self');

        Route::post('/attendance/{attendance}/add-observation', [AttendanceController::class, 'addObservation'])
            ->name('attendance.add-observation');
    });

    /*
    |--------------------------------------------------------------------------
    | Keep-Alive (Evitar Cierre de Sesión)
    |--------------------------------------------------------------------------
    */
    Route::get('/keep-alive', function () {
        return response()->json(['status' => 'ok']);
    })->name('keep-alive');
});
