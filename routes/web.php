<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\chatController;

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




Route::get('/', [chatController::class, 'index'])->name('user.login');
Route::get('/create-room', [chatController::class, 'createRoom'])->name('create.room');
Route::post('/broadcast', [chatController::class, 'broadcast'])->name('broadcast.chat');
Route::post('/chat', [chatController::class, 'chat'])->name('chat');
Route::get('/chat', [chatController::class, 'notfound'])->name('notfound');
Route::get('/rooms', [chatController::class,'rooms'])->name('rooms');
Route::post('/join', [chatController::class, 'join'])->name('room.join');
Route::post('/leave', [chatController::class, 'leave'])->name('room.leave');
Route::delete('/rooms/{id}', [chatController::class, 'deleteRoom'])->name('room.delete');
Route::post('/join-by-interests', [chatController::class, 'joinByInterests'])->name('room.join.interests');

Route::post('/interests', [chatController::class, 'storeInterest'])->name('interest.store');



use Illuminate\Http\Request;

