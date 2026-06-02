<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HRController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware'=>'auth'],function()
{
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Auth::routes();

Route::group(['namespace' => 'App\Http\Controllers\Auth'],function()
{
    // -----------------------------login----------------------------------------//
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::get('/logout', 'logout')->name('logout');
        Route::get('logout/page', 'logoutPage')->name('logout/page');
    });

    // ------------------------------ register ----------------------------------//
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/register','storeUser')->name('register');    
    });

    // ----------------------------- forget password ----------------------------//
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('forget-password', 'getEmail')->name('forget-password');
        Route::post('forget-password', 'postEmail')->name('forget-password');    
    });

    // ----------------------------- reset password -----------------------------//
    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('reset-password/{token}', 'getPassword');
        Route::post('reset-password', 'updatePassword');    
    });
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {

    // -------------------------- pages ----------------------//
    Route::controller(AccountController::class)->group(function () {
        Route::get('page/account/{user_id}', 'profileDetail')->middleware('auth');
    });

    // -------------------------- hr ----------------------//
    Route::middleware('auth')->prefix('hr')->group(function () {

        Route::controller(HRController::class)->group(function () {

            Route::get('employee/list', 'employeeList')->name('hr/employee/list');
            Route::post('employee/save', 'employeeSaveRecord')->name('hr/employee/save');
            Route::post('employee/update', 'employeeUpdateRecord')->name('hr/employee/update');
            Route::post('employee/delete', 'employeeDeleteRecord')->name('hr/employee/delete');

            Route::get('holidays/page', 'holidayPage')->name('hr/holidays/page');
            Route::post('holidays/save', 'holidaySaveRecord')->name('hr/holidays/save');
            Route::post('holidays/delete', 'holidayDeleteRecord')->name('hr/holidays/delete');

            Route::get('leave/employee/page', 'leaveEmployee')->name('hr/leave/employee/page');
            Route::get('create/leave/employee/page', 'createLeaveEmployee')->name('hr/create/leave/employee/page');
            Route::post('create/leave/employee/save', 'saveRecordLeave')->name('hr/create/leave/employee/save');
            Route::get('view/detail/leave/employee/{staff_id}', 'viewDetailLeave');

            Route::get('leave/hr/page', 'leaveHR')->name('hr/leave/hr/page');
            Route::get('attendance/page', 'attendance')->name('hr/attendance/page');

            Route::get('create/leave/hr/page', 'createLeaveHR')->name('hr/create/leave/hr/page');
            Route::post('create/leave/hr/save', 'saveRecordLeaveByHR')->name('hr/create/leave/hr/save');

            Route::post('leave/update-status', 'updateLeaveStatus')->name('hr/leave/update-status');
            Route::post('leave/delete', 'deleteLeaveRecord')->name('hr/leave/delete');

            Route::post('get/information/leave', 'getInformationLeave')->name('hr/get/information/leave');

            Route::get('attendance/main/page', 'attendanceMain')->name('hr/attendance/main/page');
            Route::post('attendance/mark', 'markAttendance')->name('hr/attendance/mark');

            Route::get('department/page', 'department')->name('hr/department/page');
            Route::post('department/save', 'saveRecordDepartment')->name('hr/department/save');
            Route::post('department/delete', 'deleteRecordDepartment')->name('hr/department/delete');
        });

        // -------------------------- Account ----------------------//

        Route::get('account', function () {

            $profileDetail = User::where(
                'email',
                Session::get('email')
            )->first();

            return view(
                'pages.account-profile',
                compact('profileDetail')
            );

        })->name('account');

        Route::post('account/avatar', [AccountController::class, 'updateAvatar'])->name('account.avatar');

        // -------------------------- Settings ----------------------//

        Route::get('settings', function () {
            return view('pages.settings');
        })->name('settings');

        // -------------------------- Maintenance ----------------------//

        Route::get('maintenance', function () {
            return view('pages.maintenance');
        })->name('maintenance');

        Route::post('maintenance/clear-cache', function () {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            Artisan::call('config:clear');

            flash()->success('System cache cleared successfully :)');
            return redirect()->route('maintenance');
        })->name('maintenance.clear-cache');

        Route::post('maintenance/optimize', function () {
            Artisan::call('optimize:clear');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');

            flash()->success('System optimized successfully :)');
            return redirect()->route('maintenance');
        })->name('maintenance.optimize');

        Route::post('maintenance/backup-database', function () {
            $backupPath = storage_path('app/backups');
            File::ensureDirectoryExists($backupPath);

            $driver = DB::getDriverName();
            $tables = $driver === 'sqlite'
                ? collect(DB::select("select name from sqlite_master where type = 'table' and name not like 'sqlite_%'"))->pluck('name')
                : collect(DB::select('SHOW TABLES'))->map(fn ($table) => array_values((array) $table)[0]);

            $backup = [
                'created_at' => now()->toDateTimeString(),
                'database' => config('database.default'),
                'tables' => [],
            ];

            foreach ($tables as $table) {
                $backup['tables'][$table] = DB::table($table)->get();
            }

            $fileName = 'database-backup-' . now()->format('Y-m-d-His') . '.json';
            File::put($backupPath . DIRECTORY_SEPARATOR . $fileName, json_encode($backup, JSON_PRETTY_PRINT));

            flash()->success('Database backup created: ' . $fileName);
            return redirect()->route('maintenance');
        })->name('maintenance.backup-database');

    });

});
