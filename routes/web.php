<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DuAnController;
use App\Http\Controllers\Backend\ClientController;
use App\Http\Controllers\Backend\NhanVienController;
use App\Http\Controllers\Backend\NotificationController;
use App\Http\Controllers\Backend\TaskController;
use App\Http\Controllers\Backend\TaiLieuController;
use App\Http\Controllers\Backend\SearchController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;



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

Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin_index');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');


    
});

Route::get('/staff/dashboard', function () {
    return view('staff.staff_dashboard');
})->name('staff_dashboard');

Route::get('/leader/dashboard', function () {
    return view('leader.leader_dashboard');
})->name('leader_dashboard');

Route::get('/supervisor/dashboard', function () {
    return view('supervisor.supervisor_dashboade');
})->name('supervisor_dashboard');




Route::get('/', [GuestController::class, 'index'])->name('guest');
Route::post('/advise', [GuestController::class, 'adviseCliet'])->name('client.store');

Route::middleware('auth','role:admin')->group(function () {
    Route::get('/client', [ClientController::class, 'index'])->name('client');
    Route::get('/client/add', [ClientController::class, 'viewAddClient'])->name('add.client');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth','role:admin')->group(function () {
    Route::get('/project/list_project',[DuAnController::class, 'viewDA'])->name('project');
    Route::get('/project/add',[DuAnController::class, 'addProject'])->name('add.project');

    Route::post('/project/add-project',[DuAnController::class, 'store'])->name('project.store');
    Route::post('/check-code', [DuAnController::class, 'checkUnique'])->name('check.code');


    Route::get('/project/{id}', [DuAnController::class, 'toggleStar'])->name('project.toggleStar');
    Route::post('/project/edit/{id}', [DuAnController::class, 'editProject'])->name('edit.project');
    Route::get('/project/lock/{id}', [DuAnController::class, 'lockProject'])->name('lock.project');

    Route::get('/project/task/{id}',[TaskController::class, 'viewtask'])->name('view.task');

    Route::get('/task/list_task',[TaskController::class, 'listTask'])->name('list.task');

    Route::get('/document',[TaiLieuController::class, 'viewDocument'])->name('view.document');
    Route::post('/task/add',[TaskController::class, 'addDo'])->name('add.do');
    Route::post('/task/file',[TaskController::class, 'addFile'])->name('add.file');
    Route::post('/task/delete',[TaiLieuController::class, 'deleteFolder'])->name('delete.folder');
    Route::get('/document/{id}', [TaiLieuController::class, 'deleteInterFolder'])->name('delete.folder.inter');
    Route::delete('/file/delete',[TaiLieuController::class, 'deleteFile'])->name('delete.file');
    Route::get('/file/{id}', [TaiLieuController::class, 'deleteInterFile'])->name('delete.file.inter');
    Route::post('/progress',[TaskController::class, 'updateProgressTask'])->name('update.progress.task');
    Route::post('/task/add-task',[TaskController::class, 'addTask'])->name('task.store');
    Route::post('/task/edit',[TaskController::class, 'editTask'])->name('task.edit');
    Route::delete('/task/delete',[TaskController::class, 'deleteTask'])->name('delete.task');


});
Route::middleware('auth')->group(function () {
    Route::get('/search', [SearchController::class, 'search'])->name('search');

});


Route::middleware('auth','role:admin')->group(function () {
    Route::get('/admin/danhsachnhanvien',[NhanVienController::class, 'index'])->name('employee');
    Route::get('/admin/themnhanvien',[NhanVienController::class, 'addEmployee'])->name('view.add.employee');
    Route::post('/admin/employees/store', [NhanVienController::class, 'store'])->name('store.employee');

    Route::delete('/admin/employees',[NhanVienController::class, 'deleteEmploye'])->name('delete-user');
    Route::post('/employees/edit', [NhanVienController::class, 'editEmployee'])->name('edit.employee');
    Route::get('/employees/lock/{id}', [NhanVienController::class, 'lockEmployee'])->name('lock.employee');

    Route::post('/check-unique', [NhanVienController::class, 'checkUnique'])->name('check.unique');

    Route::get('/admin/phancong',[NhanVienController::class, 'viewDivision'])->name('division.employee');
    Route::post('/admin/add-member',[NhanVienController::class, 'addMember'])->name('add.member');
    Route::get('/admin/delete-member={id}',[NhanVienController::class, 'deleteMember'])->name('delete.member');
    Route::post('/admin/add-division',[NhanVienController::class, 'addDivision'])->name('add.division');




});

Route::middleware('auth','role:admin')->group(function () {
    Route::post('/send-notification', [NotificationController::class, 'sendNotification'])->name('send.notification');
    Route::get('/notifications/{userId}', [NotificationController::class, 'showNotifications'])->name('show.notifications');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('mark.notification.read');


});

require __DIR__.'/auth.php';
