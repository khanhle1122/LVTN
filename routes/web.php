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
use App\Http\Controllers\Backend\ChatController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\RePortController;
use App\Http\Controllers\Backend\CoatController;
use App\Events\NewMessage;
use App\Http\Controllers\PusherAuthController;
use App\Http\Controllers\UserController;



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
Route::post('/pusher/auth', [PusherAuthController::class, 'authenticate']);

Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin_index');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');


    
});




Route::middleware('auth','role:staff')->group(function () {
    Route::get('/staff/index', [StaffController::class, 'index'])->name('staff');
    Route::get('/staff/logout', [StaffController::class, 'StaffLogout'])->name('staff.logout');
    Route::get('/staff/chat', [ChatController::class, 'index_staff'])->name('chat.staff.index');
    Route::get('/staff/profile', [StaffController::class, 'index_profile'])->name('profile.staff');
    Route::post('/staff/profile', [StaffController::class, 'editProfile'])->name('profile.update.staff');

});
Route::middleware('auth','role:leader')->group(function () {
    Route::get('/leader/index', [LeaderController::class, 'index'])->name('leader');
    Route::get('/leader/logout', [LeaderController::class, 'StaffLogout'])->name('leader.logout');
    Route::get('/leader/chat', [ChatController::class, 'index_leader'])->name('chat.leader.index');
    Route::get('/leader/profile', [LeaderController::class, 'index_profile'])->name('profile.leader');
    Route::post('/leader/profile', [LeaderController::class, 'editProfile'])->name('profile.update.leader');



});
Route::middleware('auth','role:supervisor')->group(function () {
    Route::get('/supervisor/index', [SupervisorController::class, 'index'])->name('supervisor');
    Route::get('/supervisor/logout', [SupervisorController::class, 'StaffLogout'])->name('supervisor.logout');
    Route::get('/supervisor/chat', [ChatController::class, 'index_supervisor'])->name('chat.supervisor.index');
    Route::get('/supervisor/profile', [SupervisorController::class, 'index_profile'])->name('profile.supervisor');
    Route::post('/supervisor/profile', [SupervisorController::class, 'editProfile'])->name('profile.update.supervisor');
    Route::get('/supervisor/project/task/id={id}',[TaskController::class, 'viewtaskSupervisor'])->name('view.task.supervisor');
    Route::get('/supervisor/report-project', [RePortController::class, 'reportProjectSupervisor'])->name('report.project.supervisor');
    Route::get('/supervisor/report-detail-project/id={id}', [RePortController::class, 'reportDetailSupervisor'])->name('report.detail.supervisor');


});

Route::get('/', [GuestController::class, 'index'])->name('guest');
Route::post('/advise', [GuestController::class, 'adviseCliet'])->name('client.store');

Route::middleware('auth','role:admin')->group(function () {
    Route::get('/client', [ClientController::class, 'index'])->name('client');
    Route::post('/client/themkhachhang', [ClientController::class, 'addClient'])->name('add.client');
    Route::post('/client/chinhsua', [ClientController::class, 'editClient'])->name('edit.client');
    Route::get('/duyet-request/id={id}', [ClientController::class, 'checkRequest'])->name('check.status.client');
    Route::get('/client/delete/{id}', [ClientController::class, 'deleteClient'])->name('delete.client.guest');
    Route::post('/client/import', [ClientController::class, 'import'])->name('client.import.khanh');
    
    Route::get('/report-project', [RePortController::class, 'reportProject'])->name('report.project');
    Route::get('/request', [ClientController::class, 'request'])->name('request');


});
Route::middleware('auth','role:admin')->group(function () {
    
    Route::get('/report-project/index', [RePortController::class, 'reportProject'])->name('report.project');
    Route::get('/report-detail-project/id={id}', [RePortController::class, 'reportDetail'])->name('report.detail');

});
Route::post('/report-project/store/{id}', [RePortController::class, 'store'])->name('store.report');
Route::post('/report-project/file', [RePortController::class, 'storeFlie'])->name('store.file.report');
Route::post('/report-project/edit', [RePortController::class, 'editReport'])->name('edit.report');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth','role:admin')->group(function () {
    Route::get('/project/list_project',[DuAnController::class, 'viewDA'])->name('project');

    Route::post('/project/add-project',[DuAnController::class, 'store'])->name('project.store');


    Route::get('/project/{id}', [DuAnController::class, 'toggleStar'])->name('project.toggleStar');
    Route::post('/project/edit/{id}', [DuAnController::class, 'editProject'])->name('edit.project');
    Route::get('/project/lock/{id}', [DuAnController::class, 'lockProject'])->name('lock.project');
    Route::post('/project/import', [DuAnController::class, 'import'])->name('project.import.khanh');

});

Route::middleware('auth','role:admin')->group(function () {
    Route::get('/project/task/id={id}',[TaskController::class, 'viewtask'])->name('view.task');


    Route::get('/task/list_task',[TaskController::class, 'listTask'])->name('list.task');

    Route::get('/document',[TaiLieuController::class, 'viewDocument'])->name('view.document');

    Route::post('/task/delete',[TaiLieuController::class, 'deleteFolder'])->name('delete.folder');
    Route::get('/document/{id}', [TaiLieuController::class, 'deleteInterFolder'])->name('delete.folder.inter');
    Route::delete('/file/delete',[TaiLieuController::class, 'deleteFile'])->name('delete.file');
    Route::get('/file/{id}', [TaiLieuController::class, 'deleteInterFile'])->name('delete.file.inter');


});
Route::get('/task/star{id}', [TaskController::class, 'toggleStar'])->name('task.toggleStar');

Route::post('/progress',[TaskController::class, 'updateProgressTask'])->name('update.progress.task');
Route::post('/task/add-task',[TaskController::class, 'addTask'])->name('task.store');
Route::post('/task/edit',[TaskController::class, 'editTask'])->name('task.edit');
Route::get('/task/lock/{id}', [TaskController::class, 'lockTask'])->name('lock.task');
Route::post('/task/import', [TaskController::class, 'import'])->name('task.import.khanh');

Route::post('/task/add',[TaskController::class, 'addDo'])->name('add.do');
Route::post('/task/file',[TaskController::class, 'addFile'])->name('add.file');


    Route::post('/add/coat', [CoatController::class, 'addCoat'])->name('add.coat');
    Route::post('/edit/coat', [CoatController::class, 'editCoat'])->name('edit.coat');
    Route::get('/delete/id={id}', [CoatController::class, 'deleteCoat'])->name('delete.coat');
    Route::post('/coat/import', [CoatController::class, 'import'])->name('coat.import.khanh');


Route::middleware('auth')->group(function () {
    
    Route::get('/clear-notification', [NotificationController::class, 'clearNotification'])->name('clear.notification');


});

Route::middleware('auth','role:admin')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');

});

Route::middleware('auth')->group(function () {
    Route::get('/chat/{room}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{room}/messages', [ChatController::class, 'store'])->name('chat.messages.store');
    Route::post('/chat/{room}/upload', [ChatController::class, 'uploadFile']);
    Route::post('/chat/{chatRoom}/mark-as-read', [ChatController::class, 'markAsRead']);
    Route::get('/chat/addroom/{id}', [ChatController::class, 'addRoom'])->name('addRoom.chat');

});



Route::middleware('auth')->group(function () {
    Route::get('/search', [SearchController::class, 'search'])->name('search');

});


Route::middleware('auth','role:admin')->group(function () {
    Route::get('/admin/danhsachnhanvien',[NhanVienController::class, 'index'])->name('employee');
    Route::post('/admin/employees/store', [NhanVienController::class, 'store'])->name('store.employee');

    Route::delete('/admin/employees',[NhanVienController::class, 'deleteEmploye'])->name('delete-user');
    Route::post('/employees/edit', [NhanVienController::class, 'editEmployee'])->name('edit.employee');
    Route::get('/employees/lock/{id}', [NhanVienController::class, 'lockEmployee'])->name('lock.employee');

    Route::post('/check-unique', [NhanVienController::class, 'checkUnique'])->name('check.unique');

    Route::get('/admin/phancong',[NhanVienController::class, 'viewDivision'])->name('division.employee');
    Route::post('/admin/add-member',[NhanVienController::class, 'addMember'])->name('add.member');
    Route::get('/admin/delete-member={id}',[NhanVienController::class, 'deleteMember'])->name('delete.member');
    Route::post('/admin/add-division',[NhanVienController::class, 'addDivision'])->name('add.division');
    Route::get('/admin/leader-pick={id}',[NhanVienController::class, 'leaderPick'])->name('leader.pick');
    Route::post('/users/import', [NhanVienController::class, 'import'])->name('users.import.khanh');



});

Route::middleware('auth')->group(function () {
    Route::post('/send-notification', [NotificationController::class, 'sendNotification'])->name('send.notification');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('mark.notification.read');
    Route::get('/notifications/id={id}', [NotificationController::class, 'checkNotification'])->name('check.notification');
    Route::get('/notifications/show', [NotificationController::class, 'showNotification'])->name('show.notification');
    Route::get('/notifications/delete/id={id}', [NotificationController::class, 'deleteNotification'])->name('delete.notification');


});

require __DIR__.'/auth.php';
