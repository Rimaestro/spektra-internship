<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\FieldController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Student\DailyReportController;
use App\Http\Controllers\Student\InternshipController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Halaman beranda
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Route Admin (hanya dapat diakses oleh admin)
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('fields', FieldController::class);
    
    // Manajemen user
    Route::get('/users', [DashboardController::class, 'users'])->name('users');
    Route::get('/users/create', [DashboardController::class, 'createUser'])->name('users.create');
    Route::post('/users', [DashboardController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [DashboardController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [DashboardController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [DashboardController::class, 'destroyUser'])->name('users.destroy');
});

// Route Mahasiswa (hanya dapat diakses oleh mahasiswa)
Route::prefix('student')->middleware(['auth', 'role:student'])->name('student.')->group(function () {
    Route::resource('internships', InternshipController::class);
    Route::resource('daily-reports', DailyReportController::class);
    
    // Route pengajuan PKL
    Route::get('/apply', [InternshipController::class, 'showApplyForm'])->name('apply.form');
    Route::post('/apply', [InternshipController::class, 'apply'])->name('apply.submit');
    
    // Route upload laporan
    Route::get('/reports/upload', [InternshipController::class, 'showReportUploadForm'])->name('reports.upload');
    Route::post('/reports/upload', [InternshipController::class, 'uploadReport'])->name('reports.submit');
});

// Route Dosen Pembimbing (hanya dapat diakses oleh dosen)
Route::prefix('supervisor')->middleware(['auth', 'role:supervisor'])->name('supervisor.')->group(function () {
    Route::get('/internships', [DashboardController::class, 'supervisorInternships'])->name('internships');
    Route::get('/internships/{internship}', [DashboardController::class, 'supervisorInternshipDetail'])->name('internships.show');
    
    // Evaluasi dan persetujuan
    Route::get('/internships/{internship}/evaluate', [DashboardController::class, 'supervisorEvaluationForm'])->name('internships.evaluate');
    Route::post('/internships/{internship}/evaluate', [DashboardController::class, 'supervisorEvaluate'])->name('internships.evaluate.submit');
    
    // Persetujuan laporan harian
    Route::get('/reports', [DashboardController::class, 'supervisorReports'])->name('reports');
    Route::post('/reports/{report}/approve', [DashboardController::class, 'approveReport'])->name('reports.approve');
    Route::post('/reports/{report}/reject', [DashboardController::class, 'rejectReport'])->name('reports.reject');
});

// Route Pembimbing Lapangan (hanya dapat diakses oleh pembimbing lapangan)
Route::prefix('field-supervisor')->middleware(['auth', 'role:field_supervisor'])->name('field.')->group(function () {
    Route::get('/internships', [DashboardController::class, 'fieldSupervisorInternships'])->name('internships');
    Route::get('/internships/{internship}', [DashboardController::class, 'fieldSupervisorInternshipDetail'])->name('internships.show');
    
    // Evaluasi dan persetujuan
    Route::get('/internships/{internship}/evaluate', [DashboardController::class, 'fieldSupervisorEvaluationForm'])->name('internships.evaluate');
    Route::post('/internships/{internship}/evaluate', [DashboardController::class, 'fieldSupervisorEvaluate'])->name('internships.evaluate.submit');
    
    // Persetujuan laporan harian
    Route::get('/reports', [DashboardController::class, 'fieldSupervisorReports'])->name('reports');
    Route::post('/reports/{report}/approve', [DashboardController::class, 'fieldApproveReport'])->name('reports.approve');
    Route::post('/reports/{report}/reject', [DashboardController::class, 'fieldRejectReport'])->name('reports.reject');
});

// Route Koordinator PKL (hanya dapat diakses oleh koordinator)
Route::prefix('coordinator')->middleware(['auth', 'role:coordinator'])->name('coordinator.')->group(function () {
    Route::get('/internships', [DashboardController::class, 'coordinatorInternships'])->name('internships');
    Route::get('/internships/{internship}', [DashboardController::class, 'coordinatorInternshipDetail'])->name('internships.show');
    
    // Persetujuan PKL
    Route::post('/internships/{internship}/approve', [DashboardController::class, 'approveInternship'])->name('internships.approve');
    Route::post('/internships/{internship}/reject', [DashboardController::class, 'rejectInternship'])->name('internships.reject');
    
    // Penempatan pembimbing
    Route::get('/internships/{internship}/assign-supervisor', [DashboardController::class, 'assignSupervisorForm'])->name('internships.assign');
    Route::post('/internships/{internship}/assign-supervisor', [DashboardController::class, 'assignSupervisor'])->name('internships.assign.submit');
    
    // Laporan dan statistik
    Route::get('/reports/statistics', [DashboardController::class, 'statistics'])->name('statistics');
    Route::get('/reports/export', [DashboardController::class, 'exportReports'])->name('reports.export');
});
