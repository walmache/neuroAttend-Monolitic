<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\MeetingTypeController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Record\AttendanceController;

//use App\Http\Controllers\Admin\UserController as AdminUserController;;
//use App\Http\Controllers\Admin\SystemController;

use App\Http\Controllers\Record\UserController as RecordUserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;



// Route::get('/', function () {
//     return view('welcome');
// });

// // Administración
// Route::prefix('admin')->group(function () {
//     Route::get('organizations', [OrganizationController::class, 'index'])->name('admin.organizations');
//     Route::get('meetings', [MeetingController::class, 'index'])->name('admin.meetings');
//     Route::get('users', [AdminUserController::class, 'index'])->name('admin.users');
//     Route::get('system', [SystemController::class, 'index'])->name('admin.system');
// });

// // Registro
// Route::prefix('record')->group(function () {
//     Route::get('attendance', [AttendanceController::class, 'index'])->name('record.attendance');
//     Route::get('users', [RecordUserController::class, 'index'])->name('record.users');
// });

// // Reportes
// Route::get('reports', [ReportController::class, 'index'])->name('reports');


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::middleware('auth')->group(function () {
//     Route::resource('organizations', OrganizationController::class);
//     Route::resource('meetings', MeetingController::class);
// });


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
Route::middleware('auth')->group(function () {
    
    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Administración
    Route::prefix('admin')->name('admin.')->group(function () {
        // Route::get('organizations', [OrganizationController::class, 'index'])
        //     ->name('organizations.index');
        // Route::get('meetings', [MeetingController::class, 'index'])
        //     ->name('meetings.index');
        // Route::get('users', [AdminUserController::class, 'index'])
        //     ->name('users.index');
        // Route::get('system', [SystemController::class, 'index'])
        //     ->name('system.index');
        Route::resource('organizations', OrganizationController::class);
        Route::resource('meeting-types', MeetingTypeController::class);
        Route::resource('meetings', MeetingController::class);
        Route::resource('meetings', MeetingController::class);
        Route::resource('users', UserController::class);
        


        
        // Ruta para mostrar el formulario de cambio de contraseña
        Route::get('users/{user}/change-password', [UserController::class, 'showChangePasswordForm'])
            ->name('users.change-password');

        // Ruta para procesar el cambio de contraseña
        Route::post('users/{user}/change-password', [UserController::class, 'updatePassword'])
            ->name('users.update-password');
        
            // Ruta para historial de reuniones del usuario
        Route::get('users/{user}/meetings-history', [UserController::class, 'meetingsHistory'])
        ->name('users.meetings-history');



    });

    Route::prefix('record')->name('record.')->group(function () {
        // Route::post('attendance/{meeting}/{user}', [AttendanceController::class, 'recordAttendance'])->name('attendance');
        // Route::get('attendance/signature/{meeting}/{user}', [AttendanceController::class, 'showSignatureForm'])->name('attendance.signature');
        Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
        // Listado de reuniones con usuarios pendientes de firmar
        Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        //Route::post('attendance/select', [AttendanceController::class, 'select'])->name('attendance.select');




        
    
    });





    // Reportes
    Route::get('reports', [ReportController::class, 'index'])
        ->name('reports.index');

    // Recursos adicionales (Ejemplo de Resource Controllers)

});

Route::get('/keep-alive', function () {
    // No se requiere lógica adicional, basta con que la ruta sea accesible
    return response()->json(['status' => 'ok']);
})->name('keep-alive');