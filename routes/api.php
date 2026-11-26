<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiPerpustakaanController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', function () {
    return ['message' => 'API Laravel berjalan'];
});

// Route::method('url'. [controller, function/method]) --> materi

// Route::match(['put', 'patch'], '/transactions/{id}', function (string $id) {
//     return ['message' => "PUT/PATCH /transactions/$id"];
// })->whereNumber('id');

Route::apiResource('transactions', TransactionController::class);
Route::apiResource('categories', CategoryController::class);

// Route::get('/debug/query-count', function () {
//     DB::enableQueryLog();
//     Transaction::all()->each(fn ($t) => $t->category?->nama);
//     $tanpaWith = count(DB::getQueryLog());

//     DB::flushQueryLog();
//     Transaction::with('category')->get()->each(fn ($t) => $t->category?->nama);
//     $denganWith = count(DB::getQueryLog());

//     return compact('tanpaWith', 'denganWith');
// });

// ROUTE GET

Route::get('/users', [ApiPerpustakaanController::class, 'getUsers']);

Route::get('/buku', [ApiPerpustakaanController::class, 'getBuku']);

Route::get('/kategori', [ApiPerpustakaanController::class, 'getKategori']);

Route::get('/lokasi-buku', [ApiPerpustakaanController::class, 'getLokasiBuku']);

Route::get('/anggota', [ApiPerpustakaanController::class, 'getAnggota']);

Route::get('/petugas', [ApiPerpustakaanController::class, 'getPetugas']);


//ROUTE POST
Route::post('/login', [AuthController::class, 'login']);

Route::post('/buku', [ApiPerpustakaanController::class, 'buku']);

Route::post('/kategori', [ApiPerpustakaanController::class, 'kategori']);

Route::post('/lokasi-buku', [ApiPerpustakaanController::class, 'lokasiBuku']);

Route::post('/anggota', [ApiPerpustakaanController::class, 'anggota']);

Route::post('/petugas', [ApiPerpustakaanController::class, 'petugas']);

// ROUTE PUT / UPDATE

Route::put('/users/{id}', [ApiPerpustakaanController::class, 'updateUsers']);

Route::put('/buku/{id}', [ApiPerpustakaanController::class, 'updateBuku']);

Route::put('/kategori/{id}', [ApiPerpustakaanController::class, 'updateKategori']);

Route::put('/lokasi-buku/{id}', [ApiPerpustakaanController::class, 'updateLokasiBuku']);

Route::put('/anggota/{id}', [ApiPerpustakaanController::class, 'updateAnggota']);

Route::put('/petugas/{id}', [ApiPerpustakaanController::class, 'updatePetugas']);


// ROUTE PATCH

Route::patch('/users/{id}', [ApiPerpustakaanController::class, 'patchUsers']);

Route::patch('/buku/{id}', [ApiPerpustakaanController::class, 'patchBuku']);

Route::patch('/kategori/{id}', [ApiPerpustakaanController::class, 'patchKategori']);

Route::patch('/lokasi-buku/{id}', [ApiPerpustakaanController::class, 'patchLokasiBuku']);

Route::patch('/anggota/{id}', [ApiPerpustakaanController::class, 'patchAnggota']);

Route::patch('/petugas/{id}', [ApiPerpustakaanController::class, 'patchPetugas']);


// ROUTE DELETE

Route::delete('/users/{id}', [ApiPerpustakaanController::class, 'deleteUsers']);

Route::delete('/buku/{id}', [ApiPerpustakaanController::class, 'deleteBuku']);

Route::delete('/kategori/{id}', [ApiPerpustakaanController::class, 'deleteKategori']);

Route::delete('/lokasi-buku/{id}', [ApiPerpustakaanController::class, 'deleteLokasiBuku']);

Route::delete('/anggota/{id}', [ApiPerpustakaanController::class, 'deleteAnggota']);

Route::delete('/petugas/{id}', [ApiPerpustakaanController::class, 'deletePetugas']);


Route::middleware('auth:api')->group(function () {
    Route::get('/me', function () {
        return response()->json([
            'success' => true,
            'message' => 'Profil pengguna',
            'data' => auth('api')->user()->only('id', 'name', 'email', 'role'),
        ]);
    });
});
