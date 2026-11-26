<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class TransactionController extends Controller
{
    use ApiResponse;

    private function rules(): array
    {
        return [
            'judul'       => 'required|string|max:100',
            'jumlah'      => 'required|integer|min:0',
            'catatan'     => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }

    public function index(Request $request)
    {
        try {
            $data = Transaction::with('category:id,nama')
                ->select('id', 'judul', 'jumlah', 'catatan', 'category_id')
                ->when($request->category_id, fn ($q, $id) => $q->where('category_id', $id))
                ->when($request->search, fn ($q, $s) => $q->where('judul', 'like', "%{$s}%"))
                ->latest()
                ->get();

            return $this->success($data, 'Daftar transaksi');
        } catch (Throwable $e) {
            Log::error('Gagal mengambil transaksi: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate($this->rules());
            $transaction = Transaction::create($validated);

            return $this->success($transaction->load('category:id,nama'), 'Transaksi dibuat', 201);
        } catch (ValidationException $e) {
            return $this->error('Validasi gagal', 422, $e->errors());
        } catch (Throwable $e) {
            Log::error('Gagal menyimpan transaksi: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Transaction::with('category:id,nama')->findOrFail($id);
            return $this->success($data, 'Detail transaksi');
        } catch (ModelNotFoundException $e) {
            return $this->error('Transaksi tidak ditemukan', 404);
        } catch (Throwable $e) {
            Log::error('Gagal mengambil detail transaksi: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $validated = $request->validate($this->rules());
            $transaction->update($validated);

            return $this->success($transaction->load('category:id,nama'), 'Transaksi diperbarui');
        } catch (ModelNotFoundException $e) {
            return $this->error('Transaksi tidak ditemukan', 404);
        } catch (ValidationException $e) {
            return $this->error('Validasi gagal', 422, $e->errors());
        } catch (Throwable $e) {
            Log::error('Gagal memperbarui transaksi: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Transaction::findOrFail($id)->delete();
            return $this->success(null, 'Transaksi dihapus');
        } catch (ModelNotFoundException $e) {
            return $this->error('Transaksi tidak ditemukan', 404);
        } catch (Throwable $e) {
            Log::error('Gagal menghapus transaksi: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server', 500);
        }
    }
}
